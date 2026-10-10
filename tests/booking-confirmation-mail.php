<?php
require dirname(__DIR__).'/app/config/env.php';
require dirname(__DIR__).'/app/src/Domains/Appointments/Calendar/bootstrap.php';
class_exists(App\Domains\Appointments\Calendar\Infrastructure\BookingConfirmationMailer::class);
$mail = new class(true) extends PHPMailer\PHPMailer\PHPMailer {
 public function send() { return $this->preSend(); }
};
$sender = new App\Domains\Appointments\Calendar\Infrastructure\BookingConfirmationMailer(fn()=>$mail);
$lead = ['email'=>'lead@example.com','name'=>'Lead <Test>','phone'=>'+34 612345678','service'=>'web'];
$booking = ['created'=>true,'date'=>'2026-10-15','time'=>'10:30'];
if (!$sender->send($lead,$booking) || $mail->getToAddresses()[0][0] !== 'lead@example.com' || $mail->getCcAddresses()[0][0] !== 'ikusa.creativestudio@gmail.com' || !str_contains($mail->Body,'Lead &lt;Test&gt;') || !str_contains($mail->AltBody,'15/10/2026') || !str_contains($mail->AltBody,'10:30 (Europe/Madrid)')) throw new RuntimeException('Incorrect confirmation');
$failing = new class(true) extends PHPMailer\PHPMailer\PHPMailer { public function send() { throw new RuntimeException('SMTP unavailable'); } };
if ((new App\Domains\Appointments\Calendar\Infrastructure\BookingConfirmationMailer(fn()=>$failing))->send($lead,$booking)) throw new RuntimeException('Failure must be reported');
echo "OK: destinatario, copia, fecha/hora, escape HTML, MIME y fallo SMTP sin cancelar la cita\n";
