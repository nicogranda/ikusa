
<?php
/**
 * Appointments/Views/Confirmation.php
 * Pantalla independiente para mostrar dentro del modal.
 */

$lang = $lang ?? $language ?? 'es';
$appointmentResult = $appointmentResult ?? [];

$created = !empty($appointmentResult['created']);
$emailSent = !empty($appointmentResult['email_sent']);
$treatmentName = (string) ($appointmentResult['treatment_name'] ?? '');
$date = (string) ($appointmentResult['date'] ?? '');
$time = (string) ($appointmentResult['time'] ?? '');
$message = (string) ($appointmentResult['message'] ?? '');

$e = static fn($value) => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');

if (!$created) http_response_code(422);
?>

<!DOCTYPE html>
<html lang="<?= $e($lang) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $created ? 'Cita registrada' : 'No se pudo registrar la cita' ?></title>
<style>
* { box-sizing: border-box; }
body { margin: 0; background: #fff; color: #333; font-family: Montserrat, Arial, sans-serif; }
.appointment-confirmation { display: flex; flex-direction: column; justify-content: center; align-items: center; min-height: 100dvh; padding: 28px 22px; text-align: center; }
.appointment-confirmation__icon { display: grid; place-items: center; width: 56px; height: 56px; margin-bottom: 18px; border: 1px solid #8f734a; border-radius: 50%; color: #8f734a; font-size: 27px; }
.appointment-confirmation h1 { margin: 0 0 12px; font-size: 23px; line-height: 1.3; }
.appointment-confirmation p { max-width: 360px; margin: 0 0 12px; color: #666; font-size: 13px; line-height: 1.7; }
.appointment-confirmation__details { width: 100%; max-width: 360px; margin: 12px 0; padding: 16px; background: #f7f5f0; text-align: left; }
.appointment-confirmation__details p { margin: 0 0 6px; }
.appointment-confirmation__details p:last-child { margin-bottom: 0; }
.appointment-confirmation__notice { font-size: 12px; }
.appointment-confirmation__button { margin-top: 14px; padding: 12px 24px; border: 0; border-radius: 3px; background: #8f734a; color: #fff; font: inherit; font-size: 12px; font-weight: 600; cursor: pointer; }
</style>
</head>
<body>

<section class="appointment-confirmation" role="status">
    <div class="appointment-confirmation__icon" aria-hidden="true"><?= $created ? '✓' : '!' ?></div>

    <?php if ($created): ?>
        <h1>Cita registrada</h1>
        <p>Hemos registrado tu solicitud de cita. Nuestro equipo se pondrá en contacto contigo si es necesario.</p>

        <div class="appointment-confirmation__details">
            <?php if ($treatmentName !== ''): ?><p><strong>Tratamiento:</strong> <?= $e($treatmentName) ?></p><?php endif; ?>
            <?php if ($date !== ''): ?><p><strong>Fecha:</strong> <?= $e($date) ?></p><?php endif; ?>
            <?php if ($time !== ''): ?><p><strong>Hora:</strong> <?= $e($time) ?></p><?php endif; ?>
        </div>

        <p class="appointment-confirmation__notice">
            <?= $emailSent
                ? 'Te hemos enviado un correo con los datos de tu cita.'
                : 'Tu cita está registrada, pero no hemos podido enviar el correo de confirmación.' ?>
        </p>
    <?php else: ?>
        <h1>No se pudo registrar la cita</h1>
        <p><?= $e($message !== '' ? $message : 'No hemos podido completar la reserva. Vuelve al formulario e inténtalo de nuevo.') ?></p>
    <?php endif; ?>

    <button type="button" class="appointment-confirmation__button" id="appointment-confirmation-close">Cerrar</button>
</section>

<script>
document.getElementById('appointment-confirmation-close').addEventListener('click', () => {
    // El formulario está dentro de un iframe. El modal pertenece a la página del tratamiento.
    try {
        const parentDocument = window.parent.document;
        const closeButton = parentDocument.querySelector('.modalDialogCita .close');
        if (closeButton) {
            closeButton.click();
            return;
        }
    } catch (_) {}

    window.location.href = <?= json_encode('/' . $lang . '/citas', JSON_UNESCAPED_SLASHES) ?>;
});
</script>

</body>
</html>