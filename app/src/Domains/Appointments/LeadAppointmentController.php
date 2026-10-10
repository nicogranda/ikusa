<?php
namespace App\Domains\Appointments;
require_once __DIR__ . '/Calendar/bootstrap.php';
use App\Domains\Appointments\Calendar\Infrastructure\GoogleEventRepository;
use App\Domains\Appointments\Calendar\Application\LeadBookingService;
final class LeadAppointmentController
{
    public function handle(): void
    {
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        $_SESSION['lead_booking_csrf'] ??= bin2hex(random_bytes(32));
        $_SESSION['lead_booking_request'] ??= bin2hex(random_bytes(32));
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['availability'])) {
            $localPreview = true; // Selección de servicios del formulario de Ikusa.
            $appointmentEndpoint = $_SERVER['SCRIPT_NAME'];
            $appUrl = ''; $lang = 'es';
            require __DIR__ . '/Views/LeadForm.php';
            return;
        }
        header('Content-Type: application/json; charset=utf-8');
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (!(new \App\Domains\Appointments\Calendar\Infrastructure\GoogleConnection())->connected()) {
                    http_response_code(503);
                    $this->json(['code'=>'calendar_not_connected','message'=>'Las reservas todavía no están disponibles. Contacta con Ikusa para concertar tu reunión.']);
                    return;
                }
                \App\Domains\Appointments\Calendar\Domain\BookingSchedule::date((string)($_GET['fecha'] ?? ''));
                $hours = (new LeadBookingService(new GoogleEventRepository()))->availability((string)($_GET['fecha'] ?? ''));
                $this->json(['hours'=>$hours,'available'=>count($hours)>0]); return;
            }
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Allow: GET, POST'); http_response_code(405); $this->json(['message'=>'Método no permitido.']); return; }
            if (!is_string($_POST['csrf'] ?? null) || !hash_equals($_SESSION['lead_booking_csrf'],$_POST['csrf']) || !is_string($_POST['request_id'] ?? null)) {
                http_response_code(403); $this->json(['message'=>'La sesión ha caducado. Recarga el formulario.']); return;
            }
            $request = $_POST['request_id'];
            if (isset($_SESSION['lead_booking_result'][$request])) { $this->json($_SESSION['lead_booking_result'][$request]); return; }
            if (!hash_equals($_SESSION['lead_booking_request'],$request)) { http_response_code(403); $this->json(['message'=>'Recarga el formulario para reservar.']); return; }
            if (!empty($_POST['website_fake'])) throw new \InvalidArgumentException('Solicitud no válida.');
            $directory = dirname(__DIR__,4) . '/storage/google-calendar';
            if (!is_dir($directory) && !mkdir($directory,0700,true)) throw new \RuntimeException('No se pudo iniciar la reserva.');
            $lock = fopen($directory.'/booking.lock','c');
            if (!$lock || !flock($lock,LOCK_EX)) throw new \RuntimeException('No se pudo iniciar la reserva.');
            try {
                $result = (new LeadBookingService(new GoogleEventRepository()))->book($_POST,$request);
                $_SESSION['lead_booking_result'] = [$request=>$result];
                $_SESSION['lead_booking_request'] = bin2hex(random_bytes(32));
            } finally { flock($lock,LOCK_UN); fclose($lock); }
            $result['email_sent'] = (new \App\Domains\Appointments\Calendar\Infrastructure\BookingConfirmationMailer())->send($_POST, $result);
            $_SESSION['lead_booking_result'][$request] = $result;
            $this->json($result);
        } catch (\DomainException $e) { http_response_code(409); $this->json(['unavailable'=>true,'message'=>$e->getMessage()]); }
        catch (\InvalidArgumentException $e) { http_response_code(422); $this->json(['message'=>$e->getMessage()]); }
        catch (\Throwable $e) {
            error_log('Lead booking failed: '.get_class($e).' ('.$e->getCode().')');
            http_response_code(503); $this->json(['message'=>'No podemos comprobar el calendario en este momento. Inténtalo de nuevo más tarde.']);
        }
    }
    private function json(array $data): void { echo json_encode($data,JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR); }
}
