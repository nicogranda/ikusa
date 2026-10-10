<?php
$escape = static fn($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$local = static function (array $point): string {
    if (empty($point['dateTime'])) return '';
    return (new DateTimeImmutable($point['dateTime']))->setTimezone(new DateTimeZone('Europe/Madrid'))->format('Y-m-d\TH:i');
};
?>
<!doctype html><html lang="es"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Google Calendar · Ikusa</title>
<style>body{font:16px system-ui;margin:2rem auto;max-width:1050px;padding:0 1rem;color:#222}input,textarea,button{font:inherit;padding:.5rem}label{display:block;margin:1rem 0}table{width:100%;border-collapse:collapse}td,th{text-align:left;padding:.75rem;border-bottom:1px solid #ddd}form.inline{display:inline} .notice{padding:1rem;background:#f3f3f3}button{cursor:pointer}</style>
<a href="index.php">← Panel</a><h1>Google Calendar</h1><p>Cuenta: ikusa.creativestudio@gmail.com · Horario de Madrid</p>
<?php if ($notice): ?><p class="notice" role="status"><?= $escape($notice) ?></p><?php endif ?>
<?php if ($error): ?><p class="notice" role="alert"><?= $escape($error) ?></p><?php endif ?>
<form method="post"><input type="hidden" name="csrf" value="<?= $escape($_SESSION['calendar_csrf']) ?>"><button name="action" value="connect"><?= $connected ? 'Volver a conectar Google Calendar' : 'Conectar Google Calendar' ?></button></form>
<?php if ($connected): ?>
<h2>Eventos</h2><form method="get"><input type="hidden" name="page" value="appointments"><label>Desde <input type="date" name="from" value="<?= $escape($from) ?>" required> Hasta (exclusivo) <input type="date" name="to" value="<?= $escape($to) ?>" required></label><button>Consultar</button></form>
<table><thead><tr><th>Evento</th><th>Inicio</th><th>Fin</th><th>Acciones</th></tr></thead><tbody>
<?php foreach ($events as $event): ?><tr><td><?= $escape($event['summary'] ?? '(Sin título)') ?></td><td><?= $escape(($event['start']['date'] ?? '') ?: str_replace('T', ' ', $local($event['start'] ?? []))) ?></td><td><?= $escape(($event['end']['date'] ?? '') ?: str_replace('T', ' ', $local($event['end'] ?? []))) ?></td><td>
<?php if (!empty($event['start']['dateTime']) && empty($event['recurrence'])): ?><a href="?page=appointments&amp;edit=<?= rawurlencode($event['id']) ?>">Editar</a><?php endif ?>
<form class="inline" method="post" onsubmit="return confirm('¿Eliminar este evento de Google Calendar?')"><input type="hidden" name="csrf" value="<?= $escape($_SESSION['calendar_csrf']) ?>"><input type="hidden" name="id" value="<?= $escape($event['id']) ?>"><button name="action" value="delete">Eliminar</button></form></td></tr><?php endforeach ?>
<?php if (!$events): ?><tr><td colspan="4">No hay eventos en este intervalo.</td></tr><?php endif ?></tbody></table>
<h2><?= $editing ? 'Modificar evento' : 'Crear evento' ?></h2>
<form method="post"><input type="hidden" name="csrf" value="<?= $escape($_SESSION['calendar_csrf']) ?>"><input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>"><input type="hidden" name="id" value="<?= $escape($editing['id'] ?? '') ?>">
<label>Título <input name="summary" maxlength="500" value="<?= $escape($editing['summary'] ?? '') ?>" required></label>
<label>Inicio <input type="datetime-local" name="start" value="<?= $escape($editing ? $local($editing['start']) : '') ?>" required></label>
<label>Fin <input type="datetime-local" name="end" value="<?= $escape($editing ? $local($editing['end']) : '') ?>" required></label>
<label>Descripción <textarea name="description"><?= $escape($editing['description'] ?? '') ?></textarea></label><button>Guardar evento</button></form>
<?php endif ?></html>
