<?php
// app/views/admin/irs/show.php
// Variables disponibles: $filing, $form5472, $form1120

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
$status = $filing['status'];
?>
<div style="max-width:900px;margin:0 auto;font-family:sans-serif;padding:20px;">

<a href="/admin/index.php?page=irs&action=index&company_id=<?= $filing['company_id'] ?>">&larr; Volver al listado</a>

<h2>Filing — Año <?= htmlspecialchars($filing['tax_year']) ?> — Versión <?= htmlspecialchars($filing['version']) ?></h2>

<p>
  <span style="display:inline-block;padding:4px 12px;border-radius:4px;background:<?= $statusColors[$status] ?>;color:#fff;">
    <?= $statusLabels[$status] ?? $status ?>
  </span>
  <?php if ($filing['is_corrected']): ?>
    &nbsp; <em>(corrige filing #<?= $filing['corrects_filing_id'] ?>)</em>
  <?php endif; ?>
</p>

<div style="display:flex;gap:15px;margin:20px 0;flex-wrap:wrap;">
  <a href="/admin/index.php?page=irs&action=update&id=<?= $filing['id'] ?>"
     style="padding:10px 20px;background:#F15A24;color:#fff;border-radius:5px;text-decoration:none;">
    <?= $status === 'draft' ? 'Editar' : 'Corregir (nueva versión)' ?>
  </a>

  <?php if ($status === 'draft'): ?>
    <a href="/admin/index.php?page=irs&action=mark-filed&id=<?= $filing['id'] ?>"
       onclick="return confirm('¿Confirmas que este filing ya fue presentado al IRS? Esta acción lo marca como Presentado y cualquier edición futura creará una nueva versión (amended).')"
       style="padding:10px 20px;background:#2e7d32;color:#fff;border-radius:5px;text-decoration:none;">
      Marcar como Presentado
    </a>
  <?php endif; ?>

    <?php if ($form1120): ?>
    
        <a href="/admin/index.php?page=irs&action=pdf&id=<?= $filing['id'] ?>&type=1120&mode=view"
           target="_blank"
           style="padding:10px 20px;background:#333;color:#fff;border-radius:5px;text-decoration:none;">
            Ver PDF 1120
        </a>
    
        <a href="/admin/index.php?page=irs&action=1120-proforma&id=<?= $filing['id'] ?>"
           target="_blank"
           style="padding:10px 20px;background:#1565c0;color:#fff;border-radius:5px;text-decoration:none;">
            PDF 1120 Pro Forma
        </a>
    
    <?php endif; ?>

  <?php if ($form5472): ?>
    <a href="/admin/index.php?page=irs&action=pdf&id=<?= $filing['id'] ?>&type=5472&mode=view" target="_blank"
       style="padding:10px 20px;background:#333;color:#fff;border-radius:5px;text-decoration:none;">
      Ver PDF 5472
    </a>
  <?php endif; ?>
</div>

<h3>Resumen — Form 1120</h3>
<?php if ($form1120): ?>
<table border="1" cellpadding="8" style="width:100%;border-collapse:collapse;">
  <tr><td><strong>Firmante</strong></td><td><?= htmlspecialchars($form1120['signer_name']) ?> (<?= htmlspecialchars($form1120['signer_title']) ?>)</td></tr>
  <tr><td><strong>Fecha de firma</strong></td><td><?= htmlspecialchars($form1120['signature_date']) ?></td></tr>
  <tr><td><strong>Método contable</strong></td><td><?= htmlspecialchars($form1120['accounting_method']) ?></td></tr>
  <tr><td><strong>Cash (fin de año)</strong></td><td>$<?= number_format($form1120['cash_end'], 2) ?></td></tr>
  <tr><td><strong>Common stock (fin de año)</strong></td><td>$<?= number_format($form1120['common_stock_end'], 2) ?></td></tr>
  <tr><td><strong>Retained earnings (fin de año)</strong></td><td>$<?= number_format($form1120['retained_earnings'], 2) ?></td></tr>
  <tr><td><strong>Distribuciones (Schedule K)</strong></td><td>$<?= number_format($form1120['cash_distributions'], 2) ?></td></tr>
</table>
<?php else: ?>
<p><em>No hay datos de Form 1120 para este filing.</em></p>
<?php endif; ?>

<h3>Resumen — Form 5472</h3>
<?php if ($form5472): ?>
<table border="1" cellpadding="8" style="width:100%;border-collapse:collapse;">
  <tr><td><strong>Corporación</strong></td><td><?= htmlspecialchars($form5472['corp_name']) ?></td></tr>
  <tr><td><strong>EIN</strong></td><td><?= htmlspecialchars($form5472['ein']) ?></td></tr>
  <tr><td><strong>Total de activos</strong></td><td>$<?= number_format($form5472['total_assets'], 2) ?></td></tr>
  <tr><td><strong>Shareholder</strong></td><td><?= htmlspecialchars($form5472['shareholder_name']) ?></td></tr>
  <tr><td><strong>Reference ID</strong></td><td><?= htmlspecialchars($form5472['shareholder_reference_id']) ?></td></tr>
  <tr><td><strong>Distribución (Part V)</strong></td><td>$<?= number_format($form5472['distribution_amount'], 2) ?></td></tr>
  <tr><td><strong>Ingresos de terceros</strong></td><td>$<?= number_format($form5472['third_party_gross_receipts'], 2) ?></td></tr>
</table>
<?php else: ?>
<p><em>No hay datos de Form 5472 para este filing.</em></p>
<?php endif; ?>

</div>
