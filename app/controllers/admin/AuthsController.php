<?php

class AuthsController
{
    private \mysqli $mysqli;
    private ?object $googleClient = null;

    public function __construct()
    {
        global $mysqli;
        $this->mysqli = $mysqli;

        if (class_exists(\Google\Client::class) && !empty($_ENV['GOOGLE_CLIENT_ID'])) {
            $this->googleClient = new \Google\Client([
                'client_id' => $_ENV['GOOGLE_CLIENT_ID'],
            ]);
            if (!empty($_ENV['GOOGLE_CLIENT_SECRET'])
                && !empty($_ENV['GOOGLE_REDIRECT_URI'])) {
                $this->googleClient->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
                $this->googleClient->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
                $this->googleClient->addScope('email');
                $this->googleClient->addScope('profile');
            }
        }
    }

    public function auth(): void
    {
        $host = parse_url('http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost'), PHP_URL_HOST);
        $isLocal = in_array($host, ['localhost', '127.0.0.1'], true);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (str_starts_with(strtolower($_SERVER['CONTENT_TYPE'] ?? ''), 'application/json')) {
                $this->googleCredentialLogin();
                return;
            }
            if (!$isLocal) {
                http_response_code(405);
                return;
            }
            $this->passwordLogin();
            return;
        }

        if (!empty($_SESSION['user_id'])) {
            header('Location: ' . $this->panelUrl());
            exit;
        }

        if (isset($_GET['code'])) {
            if ($this->googleClient === null) {
                $_SESSION['error'] = 'El acceso con Google no está configurado aquí.';
                header('Location: ' . route_url('admin'));
                exit;
            }
            $this->handleGoogleCallback((string) $_GET['code']);
            return;
        }

        $googleLoginEnabled = $this->googleClient !== null;
        if ($googleLoginEnabled) {
            $_SESSION['google_login_csrf'] ??= bin2hex(random_bytes(32));
        }
        include __DIR__ . '/../../views/admin/auth/login.php';
    }

    private function googleCredentialLogin(): void
    {
        header('Content-Type: application/json; charset=UTF-8');

        $csrf = (string) ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
        if ($this->googleClient === null || $csrf === ''
            || !hash_equals((string) ($_SESSION['google_login_csrf'] ?? ''), $csrf)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Solicitud no autorizada.']);
            return;
        }

        $request = json_decode(file_get_contents('php://input'), true);
        $credential = is_array($request) ? ($request['credential'] ?? null) : null;
        if (!is_string($credential) || strlen($credential) > 8192 || $credential === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Token no válido.']);
            return;
        }

        try {
            $claims = $this->googleClient->verifyIdToken($credential);
            $email = is_array($claims) ? ($claims['email'] ?? null) : null;
            if (!$claims || empty($claims['email_verified'])
                || !is_string($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \RuntimeException('Token de Google inválido.');
            }

            // Para emails externos Google no garantiza la titularidad actual.
            $gmail = str_ends_with(strtolower($email), '@gmail.com');
            if (!$gmail && empty($claims['hd'])) {
                throw new \RuntimeException('La cuenta requiere verificación adicional.');
            }

            $stmt = $this->mysqli->prepare(
                'SELECT id, username, name, lastname, email, role
                 FROM users WHERE email = ? LIMIT 1'
            );
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$user || $user['role'] !== 'admin') {
                throw new \RuntimeException('La cuenta no tiene acceso al panel.');
            }

            unset($_SESSION['google_login_csrf']);
            $this->startSession($user);
            echo json_encode(['success' => true, 'redirect' => $this->panelUrl()]);
        } catch (\Throwable $exception) {
            error_log('Admin Google token rejected: ' . $exception->getMessage());
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'No se pudo iniciar sesión con Google.']);
        }
    }

    private function passwordLogin(): void
    {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($username !== '' && $password !== '') {
            $stmt = $this->mysqli->prepare(
                'SELECT id, username, name, lastname, email, role, password
                 FROM users WHERE username = ? LIMIT 1'
            );
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($user && $user['role'] === 'admin'
                && password_verify($password, (string) $user['password'])) {
                $this->startSession($user);
                header('Location: ' . $this->panelUrl());
                exit;
            }
        }

        $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
        header('Location: ' . route_url('admin'));
        exit;
    }

    private function handleGoogleCallback(string $code): void
    {
        try {
            $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);
            if (isset($token['error'])) {
                throw new \RuntimeException('No se pudo validar el acceso con Google.');
            }

            $this->googleClient->setAccessToken($token);
            $oauth2 = new \Google\Service\Oauth2($this->googleClient);
            $email = (string) $oauth2->userinfo->get()->email;

            $stmt = $this->mysqli->prepare(
                'SELECT id, username, name, lastname, email, role
                 FROM users WHERE email = ? LIMIT 1'
            );
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$user || $user['role'] !== 'admin') {
                throw new \RuntimeException('Esta cuenta no tiene acceso al panel.');
            }

            $this->startSession($user);
            header('Location: ' . $this->panelUrl());
            exit;
        } catch (\Throwable $exception) {
            error_log('Admin Google login failed: ' . $exception->getMessage());
            $_SESSION['error'] = 'No se pudo iniciar sesión con Google.';
            header('Location: ' . route_url('admin'));
            exit;
        }
    }

    private function startSession(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['username'];
        $_SESSION['user_nick'] = trim(($user['name'] ?? '') . ' ' . ($user['lastname'] ?? ''));
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'role' => 'admin',
        ];
    }

    private function panelUrl(): string
    {
        return rtrim(dirname(asset_url('img/favicon.png'), 3), '/') . '/admin/index.php';
    }
}
