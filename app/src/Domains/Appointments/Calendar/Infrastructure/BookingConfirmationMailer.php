<?php
namespace App\Domains\Appointments\Calendar\Infrastructure;
use App\Domains\Appointments\Calendar\Application\LeadBookingService;
use PHPMailer\PHPMailer\PHPMailer;
require_once dirname(__DIR__, 5) . '/libraries/PHPMailer/src/Exception.php';
require_once dirname(__DIR__, 5) . '/libraries/PHPMailer/src/PHPMailer.php';
require_once dirname(__DIR__, 5) . '/libraries/PHPMailer/src/SMTP.php';
final class BookingConfirmationMailer
{
    public function __construct(private ?\Closure $factory = null) {}
    public function send(array $lead, array $booking): bool
    {
        try {
            $mail = $this->factory ? ($this->factory)() : new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $_ENV['MAIL_HOST'] ?? '';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_USERNAME'] ?? '';
            $mail->Password = $_ENV['MAIL_PASSWORD'] ?? '';
            $mail->Port = (int)($_ENV['MAIL_PORT'] ?? 465);
            $mail->SMTPSecure = $mail->Port === 465 ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Timeout = 15;
            $mail->SMTPDebug = 0;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'] ?? $mail->Username, $_ENV['MAIL_FROM_NAME'] ?? 'Ikusa Creative Studio');
            $mail->addAddress(trim($lead['email']), trim($lead['name']));
            $mail->addCC('ikusa.creativestudio@gmail.com', 'Ikusa Creative Studio');
            $mail->addReplyTo('ikusa.creativestudio@gmail.com', 'Ikusa Creative Studio');
            $date = \DateTimeImmutable::createFromFormat('!Y-m-d', $booking['date'])->format('d/m/Y');
            $service = LeadBookingService::SERVICES[$lead['service']];
            $text = "Hola {$lead['name']},\n\nTu reunión con Ikusa está reservada.\n\nFecha: $date\nHora: {$booking['time']} (Europe/Madrid)\nDuración: 30 minutos\nServicio: $service\nNombre: {$lead['name']}\nTeléfono: {$lead['phone']}\nCorreo: {$lead['email']}\n\nSi necesitas cambiar la cita, responde a este correo.\n\nIkusa Creative Studio";
            $mail->Subject = "Confirmación de tu cita con Ikusa · $date a las {$booking['time']}";
            $mail->isHTML(true);
            $mail->Body = '<div style="font-family:Arial,sans-serif;line-height:1.6;color:#333"><h1 style="color:#F15A24;font-size:24px">Tu cita está reservada</h1><p>' . nl2br(htmlspecialchars($text, ENT_QUOTES, 'UTF-8')) . '</p></div>';
            $mail->AltBody = $text;
            return $mail->send();
        } catch (\Throwable $e) {
            error_log('Booking confirmation email failed: '.get_class($e).' ('.$e->getCode().')');
            return false;
        }
    }
}
