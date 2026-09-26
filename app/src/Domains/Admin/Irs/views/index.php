<?php
// app/views/admin/irs/index.php
// Variables disponibles: $filings (array de irs_filings + form5472_id + form1120_id)

$companyId = (int)($_GET['company_id'] ?? 1);

$statusLabels = [
    'draft' => 'Borrador',
    'filed' => 'Presentado',
    'corrected' => 'Corregido',
    'superseded' => 'Reemplazado',
];
$statusColors = [
    'draft' => '#999',
    'filed' => '#2e7d32',
    'corrected' => '#F15A24',
    'superseded' => '#999',
];
?>
<div style="max-width:900px;margin:0 auto;font-family:sans-serif;padding:20px;">

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
  <h2>Declaraciones IRS</h2>
  <a href="/admin/index.php?page=irs&action=create&company_id=<?= $companyId ?>&tax_year=<?= date('Y') ?>"
     style="padding:10px 20px;background:#F15A24;color:#fff;border-radius:5px;text-decoration:none;">
    + Nueva declaración
  </a>
</div>

<?php if (empty($filings)): ?>
<p><em>No hay declaraciones registradas todavía.</em></p>
<?php else: ?>
<table border="1" cellpadding="10" style="width:100%;border-collapse:collapse;">
<thead>
<tr style="background:#f3f3f3;text-align:left;">
  <th>Año</th>
  <th>Versión</th>
  <th>Estado</th>
  <th>Form 5472</th>
  <th>Form 1120</th>
  <th>Corrige</th>
  <th></th>
</tr>
</thead>
<tbody>
<?php foreach ($filings as $f): ?>
<tr>
  <td><?= htmlspecialchars($f['tax_year']) ?></td>
  <td>v<?= htmlspecialchars($f['version']) ?></td>
  <td>
    <span style="display:inline-block;padding:3px 10px;border-radius:4px;background:<?= $statusColors[$f['status']] ?? '#999' ?>;color:#fff;font-size:0.85em;">
      <?= $statusLabels[$f['status']] ?? $f['status'] ?>
    </span>
  </td>
  <td><?= $f['form5472_id'] ? '✓' : '—' ?></td>
  <td><?= $f['form1120_id'] ? '✓' : '—' ?></td>
  <td><?= $f['is_corrected'] ? '#' . htmlspecialchars($f['corrects_filing_id']) : '—' ?></td>
  <td>
    <a href="/admin/index.php?page=irs&action=show&id=<?= $f['id'] ?>"
       style="color:#F15A24;text-decoration:none;font-weight:bold;">
      Ver &rarr;
    </a>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>

</div>
