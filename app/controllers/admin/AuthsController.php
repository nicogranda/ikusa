<?php
require_once '../app/libraries/admin/Model.php';
require_once '../app/models/admin/Auth.php';
use App\Models\Admin\Auth;

class AuthsController
{
    private mysqli $mysqli;
    private Auth $auth;
    private \Google\Client $googleClient;

    public function __construct()
    {
        global $mysqli;
        if (!isset($mysqli)) {
            $mysqli = new mysqli(
                $_ENV['DB_HOST'], $_ENV['DB_USER'],
                $_ENV['DB_PASS'], $_ENV['DB_NAME']
            );
            if ($mysqli->connect_errno) {
                die("Error MySQL: " . $mysqli->connect_error);
            }
        }
        $this->mysqli = $mysqli;
        $this->auth   = new Auth();

        $this->googleClient = new \Google\Client();
        $this->googleClient->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $this->googleClient->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $this->googleClient->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function auth()
    {
        if (!empty($_SESSION['user_id'])) {
            header("Location: /admin");
            exit();
        }

        if (isset($_GET['code'])) {
            $this->handleGoogleCallback($_GET['code']);
            return;
        }

        $googleAuthUrl = $this->googleClient->createAuthUrl();
        include "../app/views/admin/auth/login.php";
    }

    private function handleGoogleCallback(string $code): void
    {
        try {
            $token = $this->googleClient->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                $_SESSION['error'] = "Error al autenticar con Google.";
                header("Location: /login");
                exit();
            }

            $this->googleClient->setAccessToken($token);
            $oauth2     = new \Google\Service\Oauth2($this->googleClient);
            $googleUser = $oauth2->userinfo->get();
            $email      = $googleUser->email;

            $stmt = $this->mysqli->prepare(
                "SELECT * FROM users WHERE email = ? LIMIT 1"
            );
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$user) {
                $_SESSION['error'] = "Este email no tiene acceso.";
                header("Location: /login");
                exit();
            }

            if ($user['role'] !== 'admin') {
                $_SESSION['error'] = "Acceso denegado. Solo administradores.";
                header("Location: /login");
                exit();
            }

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = htmlspecialchars($user['username']);
            $_SESSION['user_nick'] = htmlspecialchars(
                ($user['name'] ?? '') . ' ' . ($user['lastname'] ?? '')
            );
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'email' => $email,
                'name'  => $user['name'],
                'role'  => $user['role'],
            ];

            header("Location: /admin");
            exit();

        } catch (\Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: /login");
            exit();
        }
    }
}