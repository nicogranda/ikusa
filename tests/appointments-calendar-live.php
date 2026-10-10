<?php
// Prueba real: crea un único evento temporal, lo modifica y lo elimina.
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require dirname(__DIR__) . '/app/config/env.php';
require dirname(__DIR__) . '/app/src/Domains/Appointments/Calendar/bootstrap.php';
use App\Domains\Appointments\Calendar\Infrastructure\GoogleConnection;
use App\Domains\Appointments\Calendar\Infrastructure\GoogleEventRepository;
use App\Domains\Appointments\Calendar\Application\CalendarService;
if (!(new GoogleConnection())->connected()) {
    fwrite(STDERR, "PENDIENTE: autoriza Google Calendar en el panel de Appointments antes de la prueba real.\n");
    exit(2);
}
$service = new CalendarService(new GoogleEventRepository());
$start = new DateTimeImmutable('tomorrow 09:00', new DateTimeZone('Europe/Madrid'));
$id = null;
$failed = false;
try {
    $data = ['summary'=>'Ikusa · prueba de integración '.bin2hex(random_bytes(4)), 'description'=>'Evento temporal de verificación automática.', 'start'=>$start->format('Y-m-d\TH:i'), 'end'=>$start->modify('+15 minutes')->format('Y-m-d\TH:i')];
    $event = $service->create($data); $id = $event['id'] ?? null;
    if (!$id) throw new RuntimeException('Google no devolvió el ID.');
    $data['summary'] .= ' · modificado';
    $service->update($id, $data);
    if (($service->get($id)['summary'] ?? '') !== $data['summary']) throw new RuntimeException('La modificación no se ha confirmado.');
    $events = $service->list($start->format('Y-m-d'), $start->modify('+1 day')->format('Y-m-d'));
    if (!in_array($id,array_column($events,'id'),true)) throw new RuntimeException('El evento no aparece en la consulta.');
} catch (Throwable $e) {
    fwrite(STDERR,'ERROR: '.get_class($e).' ('.$e->getCode().")\n"); $failed = true;
} finally {
    if ($id !== null) $service->delete($id);
}
if ($failed) exit(1);
echo "OK: creación, modificación, consulta y eliminación reales.\n";
