<?php
namespace App\Domains\Appointments\Calendar;
use App\Domains\Appointments\Calendar\Infrastructure\GoogleConnection;
use App\Domains\Appointments\Calendar\Infrastructure\GoogleEventRepository;
use App\Domains\Appointments\Calendar\Application\CalendarService;
final class CalendarController
{
    public function handle(): void
    {
        if (empty($_SESSION['user_id']) || ($_SESSION['user']['role'] ?? '') !== 'admin') { http_response_code(403); exit('Acceso no autorizado.'); }
        header('Cache-Control: no-store');
        header('Referrer-Policy: no-referrer');
        $_SESSION['calendar_csrf'] ??= bin2hex(random_bytes(32));
        $error = null;
        $events = [];
        $editing = null;
        $connected = false;
        $connection = new GoogleConnection();
        $from = (string) ($_GET['from'] ?? date('Y-m-01'));
        $to = (string) ($_GET['to'] ?? date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-01')))));
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['calendar_csrf'], $_POST['csrf'])) { http_response_code(403); exit('Solicitud no autorizada.'); }
                $action = $_POST['action'] ?? '';
                if ($action === 'connect') { header('Location: ' . $connection->authorizationUrl()); exit; }
                $service = new CalendarService(new GoogleEventRepository());
                switch ($action) {
                    case 'create': $service->create($_POST); break;
                    case 'update': $service->update((string) ($_POST['id'] ?? ''), $_POST); break;
                    case 'delete': $service->delete((string) ($_POST['id'] ?? '')); break;
                    default: throw new \InvalidArgumentException('Operación desconocida.');
                }
                $_SESSION['calendar_notice'] = 'Evento guardado correctamente.';
                header('Location: index.php?page=appointments', true, 303); exit;
            }
            $connected = $connection->connected();
            if ($connected) {
                $service = new CalendarService(new GoogleEventRepository());
                $events = $service->list($from, $to);
                if (isset($_GET['edit'])) $editing = $service->get((string) $_GET['edit']);
            }
        } catch (\InvalidArgumentException $e) { $error = $e->getMessage(); http_response_code(400); }
        catch (\Throwable $e) {
            // Nunca registrar la respuesta OAuth, tokens o secretos.
            error_log('Calendar request failed: ' . get_class($e) . ' (' . $e->getCode() . ')');
            $error = $e instanceof \Google\Service\Exception ? 'Google Calendar rechazó la operación. Revisa los permisos y la conexión.' : $e->getMessage();
            http_response_code(502);
        }
        $notice = $_SESSION['calendar_notice'] ?? null;
        unset($_SESSION['calendar_notice']);
        require __DIR__ . '/Views/index.php';
    }
    public static function callback(): void
    {
        try { (new GoogleConnection())->callback($_GET); $_SESSION['calendar_notice'] = 'Google Calendar conectado.'; }
        catch (\Throwable $e) { $_SESSION['calendar_notice'] = $e instanceof \RuntimeException && !($e instanceof \Google\Service\Exception) ? $e->getMessage() : 'No se pudo conectar Google Calendar. Vuelve a intentarlo.'; }
        $panel = rtrim(dirname(asset_url('img/favicon.png'), 3), '/') . '/admin/index.php?page=appointments';
        header('Location: ' . $panel);
        exit;
    }
}
