
<?php
/**
 * AVALON ESTETIC — APPOINTMENTS
 * Views/Components/Availability.php
 */

$fecha = $_GET['fecha'] ?? '';
$planta = strtoupper($_GET['planta'] ?? 'PB');
$tratamiento = (int) ($_GET['tratamiento'] ?? 0);

if (!in_array($planta, ['PA', 'PB'], true)) $planta = 'PB';

$timezone = new DateTimeZone('Europe/Madrid');
$today = new DateTimeImmutable('today', $timezone);
$date = DateTimeImmutable::createFromFormat('!Y-m-d', $fecha, $timezone);

if (!$date || $date->format('Y-m-d') !== $fecha || $date < $today) {
    http_response_code(400);
    exit('Fecha no válida.');
}

require_once dirname(__DIR__, 2) . '/Calendar/bootstrap.php';
try {
    $horarios = (new \App\Domains\Appointments\Calendar\Application\LeadBookingService(
        new \App\Domains\Appointments\Calendar\Infrastructure\GoogleEventRepository()
    ))->availability($fecha);
} catch (\Throwable $e) {
    http_response_code(503);
    exit('No podemos comprobar el calendario en este momento. Inténtalo de nuevo más tarde.');
}
$ocupados = [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Disponibilidad | <?= !empty($localPreview) ? 'Ikusa' : 'Avalon Estetic' ?></title>
<style>
* { box-sizing: border-box; }
body { margin: 0; padding: 25px; font-family: Montserrat, Arial, sans-serif; color: #333; background: #fff; }
.availability { max-width: 500px; margin: auto; }
.availability__header { text-align: center; margin-bottom: 25px; }
.availability__eyebrow { color: #8f734a; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; }
.availability h1 { font-size: 22px; font-weight: 600; margin: 10px 0; }
.availability__date { font-size: 14px; color: #666; }
.availability__grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.availability__hour { padding: 14px 5px; border: 1px solid #ddd; background: #fff; color: #333; font: inherit; font-size: 14px; cursor: pointer; transition: .2s; }
.availability__hour:hover { background: #8f734a; border-color: #8f734a; color: #fff; }
.availability__hour:disabled { background: #f5f5f5; color: #aaa; border-color: #eee; cursor: not-allowed; text-decoration: line-through; }
.availability__message { text-align: center; margin-top: 20px; font-size: 13px; color: #777; }
.availability__back { display: block; margin: 25px auto 0; padding: 10px 20px; background: none; border: 0; color: #8f734a; font: inherit; font-size: 13px; cursor: pointer; }
@media(max-width:400px) { body { padding: 15px; } .availability__grid { grid-template-columns: repeat(2, 1fr); } }
</style>
</head>
<body>

<section class="availability">

    <header class="availability__header">
        <span class="availability__eyebrow"><?= !empty($localPreview) ? 'IKUSA · Reunión de 30 minutos' : 'AVALON ESTETIC · ' . htmlspecialchars($planta) ?></span>
        <h1>Selecciona una hora</h1>
        <p class="availability__date"><?= htmlspecialchars($date->format('d/m/Y')) ?></p>
    </header>

    <div class="availability__grid">

        <?php foreach ($horarios as $hora): ?>
            <?php $ocupado = in_array($hora, $ocupados, true); ?>

            <button type="button" class="availability__hour" data-hour="<?= htmlspecialchars($hora) ?>" <?= $ocupado ? 'disabled' : '' ?>>
                <?= htmlspecialchars($hora) ?>
            </button>

        <?php endforeach; ?>

    </div>

    <p class="availability__message"><?= $horarios ? 'Selecciona el horario que prefieras.' : 'No hay horas disponibles para esta fecha. Selecciona otro día.' ?></p>

    <button type="button" class="availability__back" onclick="window.close()">Volver al formulario</button>

</section>


<script>
document.querySelectorAll('.availability__hour:not(:disabled)').forEach(button => {
    button.addEventListener('click', () => {
        const fecha = <?= json_encode($fecha, JSON_UNESCAPED_SLASHES) ?>;
        const hora = button.dataset.hour;

        if (!window.opener || window.opener.closed) {
            alert('No se ha encontrado el formulario de citas.');
            return;
        }

        if (typeof window.opener.setAppointmentTime !== 'function') {
            alert('El formulario no está preparado para recibir el horario.');
            return;
        }

        window.opener.setAppointmentTime(fecha, hora);
        window.close();
    });
});
</script>

</body>
</html>
