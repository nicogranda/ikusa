<?php
namespace App\Domains\Appointments\Calendar\Infrastructure;
final class GoogleConnection
{
    public const SCOPE = 'https://www.googleapis.com/auth/calendar.events';
    private FileTokenStore $store;
    public function __construct(?FileTokenStore $store = null, private ?\Closure $clientFactory = null)
    {
        $this->store = $store ?? new FileTokenStore(dirname(__DIR__, 6) . '/storage/google-calendar/token.json');
    }
    public static function redirectUri(): string
    {
        $host = parse_url('http://' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST);
        return in_array($host, ['localhost', '127.0.0.1'], true)
            ? 'http://localhost:8888/ikusa/admin' : 'https://ikusa.net/admin';
    }
    public function client(): \Google\Client
    {
        if ($this->clientFactory !== null) return ($this->clientFactory)();
        if (empty($_ENV['GOOGLE_CLIENT_ID']) || empty($_ENV['GOOGLE_CLIENT_SECRET'])) throw new \RuntimeException('OAuth de Google no está configurado.');
        $client = new \Google\Client();
        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $client->setRedirectUri(self::redirectUri());
        $client->setScopes(['openid', 'email', self::SCOPE]);
        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);
        return $client;
    }
    public function connected(): bool { return !empty($this->store->read()['refresh_token']); }
    public function authorizationUrl(): string
    {
        $state = bin2hex(random_bytes(32));
        $_SESSION['calendar_oauth'] = ['state' => $state, 'expires' => time() + 600, 'user_id' => $_SESSION['user_id']];
        $client = $this->client();
        $client->setState($state);
        $client->setPrompt('consent');
        $client->setLoginHint('ikusa.creativestudio@gmail.com');
        return $client->createAuthUrl();
    }
    public function callback(array $query): void
    {
        $pending = $_SESSION['calendar_oauth'] ?? [];
        unset($_SESSION['calendar_oauth']);
        if (empty($_SESSION['user_id']) || ($_SESSION['user']['role'] ?? '') !== 'admin'
            || ($pending['user_id'] ?? null) !== $_SESSION['user_id']
            || ($pending['expires'] ?? 0) < time() || !is_string($query['state'] ?? null)
            || empty($pending['state']) || !hash_equals($pending['state'], $query['state'])) {
            throw new \RuntimeException('La autorización ha caducado o no es válida.');
        }
        if (!empty($query['error']) || !is_string($query['code'] ?? null) || $query['code'] === '') throw new \RuntimeException('No se ha autorizado Calendar.');
        $client = $this->client();
        $token = $client->fetchAccessTokenWithAuthCode($query['code']);
        if (isset($token['error']) || empty($token['access_token'])) throw new \RuntimeException('No se pudo autorizar Calendar.');
        $claims = $client->verifyIdToken($token['id_token'] ?? '');
        if (!$claims || empty($claims['email_verified']) || strtolower($claims['email'] ?? '') !== 'ikusa.creativestudio@gmail.com') throw new \RuntimeException('Conecta la cuenta ikusa.creativestudio@gmail.com.');
        $scopes = explode(' ', $token['scope'] ?? '');
        if (!in_array(self::SCOPE, $scopes, true)) throw new \RuntimeException('Debes conceder acceso a los eventos de Calendar.');
        if (empty($token['refresh_token'])) throw new \RuntimeException('Google no devolvió acceso offline. Vuelve a conectar Calendar.');
        $token['created'] ??= time();
        $token['account_email'] = $claims['email'];
        $this->store->write($token);
    }
    public function authorizedClient(): \Google\Client
    {
        $lock = $this->store->lock();
        try {
            $token = $this->store->read();
            if (empty($token['refresh_token'])) throw new \RuntimeException('Conecta Google Calendar desde el panel.');
            $client = $this->client();
            $client->setAccessToken($token);
            if ($client->isAccessTokenExpired()) {
                $updated = $client->fetchAccessTokenWithRefreshToken($token['refresh_token']);
                if (isset($updated['error']) || empty($updated['access_token'])) {
                    if (($updated['error'] ?? '') === 'invalid_grant') $this->store->write([]);
                    throw new \RuntimeException('No se pudo renovar Calendar. Revisa la conexión o vuelve a autorizar.');
                }
                $updated['refresh_token'] = $updated['refresh_token'] ?? $token['refresh_token'];
                $updated['created'] ??= time();
                $updated['account_email'] = $token['account_email'] ?? '';
                $this->store->write($updated);
                $client->setAccessToken($updated);
            }
            return $client;
        } finally { flock($lock, LOCK_UN); fclose($lock); }
    }
}
