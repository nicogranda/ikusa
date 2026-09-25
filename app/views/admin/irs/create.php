<?php
// app/views/admin/irs/create.php
// Variables disponibles: $company, $shareholder, $financials, $stockTotal, $form5472, $form1120, $filing

$companyId = $company['id'];
$taxYear   = $_GET['tax_year'] ?? date('Y');
$isEdit    = !empty($filing);

// Helper: valor de form_5472/form_1120 si existe (editar), si no, del snapshot de companies/shareholders (primera vez)
function v($form, $key, $fallback = '') {
    if ($form && isset($form[$key]) && $form[$key] !== null) return $form[$key];
    return $fallback;
}

$f5 = $form5472 ?? null;
$f1 = $form1120 ?? null;
$totalAssets = v($f5, 'total_assets', $financials['total_assets'] ?? 0);
$grossPayments = v($f5, 'gross_payments_form', $financials['gross_payments'] ?? 0);
$commonStock = $stockTotal['total'] ?? 0;
?>
<div style="max-width:900px;margin:0 auto;font-family:sans-serif;padding:20px;">
<h2>Declaración IRS — <?= htmlspecialchars($company['name']) ?> — Año <?= htmlspecialchars($taxYear) ?></h2>

<form action="/admin/index.php?page=irs&action=<?= $isEdit ? 'update&id=' . $filing['id'] : 'store' ?>" method="post">

<input type="hidden" name="company_id" value="<?= $companyId ?>">
<input type="hidden" name="tax_year" value="<?= htmlspecialchars($taxYear) ?>">
<?php if ($isEdit): ?><input type="hidden" name="id" value="<?= $filing['id'] ?>"><?php endif; ?>

<h3>Corporación (compartido 5472 / 1120)</h3>
<div class="form-group"><label>Nombre</label>
  <input type="text" name="corp_name" value="<?= htmlspecialchars(v($f5,'corp_name',$company['name'])) ?>"></div>
<div class="form-group"><label>Dirección</label>
  <input type="text" name="corp_address" value="<?= htmlspecialchars(v($f5,'corp_address',$company['address'])) ?>"></div>
<div class="form-group"><label>Ciudad</label>
  <input type="text" name="corp_city" value="<?= htmlspecialchars(v($f5,'corp_city',$company['city'])) ?>"></div>
<div class="form-group"><label>Estado</label>
  <input type="text" name="corp_state" value="<?= htmlspecialchars(v($f5,'corp_state',$company['state'])) ?>"></div>
<div class="form-group"><label>País (1120)</label>
  <input type="text" name="corp_country" value="<?= htmlspecialchars(v($f1,'corp_country',$company['country'] ?? 'United States')) ?>"></div>
<div class="form-group"><label>ZIP</label>
  <input type="text" name="corp_zip" value="<?= htmlspecialchars(v($f5,'corp_zip',$company['zip'])) ?>"></div>
<div class="form-group"><label>EIN</label>
  <input type="text" name="ein" value="<?= htmlspecialchars(v($f5,'ein',$company['ein'])) ?>"></div>
<div class="form-group"><label>Fecha de incorporación</label>
  <input type="date" name="incorporation_date" value="<?= htmlspecialchars(v($f5,'incorporation_date',$company['incorporation_date'])) ?>"></div>
<input type="hidden" name="date_incorporated" value="<?= htmlspecialchars(v($f5,'incorporation_date',$company['incorporation_date'])) ?>">
<div class="form-group"><label>País de incorporación</label>
  <input type="text" name="incorporation_country" value="<?= htmlspecialchars(v($f5,'incorporation_country',$company['incorporation_country'])) ?>"></div>
<div class="form-group"><label>Actividad principal</label>
  <input type="text" name="business_activity" value="<?= htmlspecialchars(v($f5,'business_activity',$company['business_activity'])) ?>"></div>
<input type="hidden" name="activity" value="<?= htmlspecialchars(v($f5,'business_activity',$company['business_activity'])) ?>">
<div class="form-group"><label>Código de actividad</label>
  <input type="text" name="activity_code" value="<?= htmlspecialchars(v($f5,'activity_code',$company['activity_code'])) ?>"></div>
<div class="form-group"><label>Total de activos ($)</label>
  <input type="number" step="0.01" name="total_assets" value="<?= htmlspecialchars($totalAssets) ?>"></div>
<div class="form-group"><label>Países donde opera el negocio</label>
  <input type="text" name="principal_countries_business" value="<?= htmlspecialchars(v($f5,'principal_countries_business','United States, Spain')) ?>"></div>

<h3>Casillas Part I (Form 5472)</h3>
<label><input type="checkbox" name="foreign_owned_50pct" <?= v($f5,'foreign_owned_50pct',1) ? 'checked' : '' ?>> ≥50% propiedad extranjera</label><br>
<label><input type="checkbox" name="is_disregarded_entity" <?= v($f5,'is_disregarded_entity',1) ? 'checked' : '' ?>> Foreign-owned U.S. DE</label>

<h3>Shareholder / Related Party</h3>
<input type="hidden" name="shareholder_id" value="<?= $shareholder['id'] ?>">
<div class="form-group"><label>Nombre</label>
  <input type="text" name="shareholder_name" value="<?= htmlspecialchars(v($f5,'shareholder_name',$shareholder['name'])) ?>"></div>
<div class="form-group"><label>Dirección completa (una línea)</label>
  <input type="text" name="shareholder_full_address_line" value="<?= htmlspecialchars(v($f5,'shareholder_full_address_line',$shareholder['full_address_line'])) ?>"></div>
<div class="form-group"><label>Reference ID</label>
  <input type="text" name="shareholder_reference_id" value="<?= htmlspecialchars(v($f5,'shareholder_reference_id',$shareholder['reference_id'])) ?>"></div>
<div class="form-group"><label>FTIN</label>
  <input type="text" name="shareholder_ftin" value="<?= htmlspecialchars(v($f5,'shareholder_ftin',$shareholder['ftin'])) ?>"></div>
<div class="form-group"><label>País</label>
  <input type="text" name="shareholder_country" value="<?= htmlspecialchars(v($f5,'shareholder_country',$shareholder['country'])) ?>"></div>
<div class="form-group"><label>Nacionalidad</label>
  <input type="text" name="shareholder_citizenship_country" value="<?= htmlspecialchars(v($f5,'shareholder_citizenship_country',$shareholder['citizenship_country'] ?? '')) ?>"></div>
<div class="form-group"><label>País donde declara impuestos</label>
  <input type="text" name="shareholder_tax_country" value="<?= htmlspecialchars(v($f5,'shareholder_tax_country',$shareholder['tax_country'])) ?>"></div>
<div class="form-group"><label>Actividad del related party</label>
  <input type="text" name="related_party_activity" value="<?= htmlspecialchars(v($f5,'related_party_activity',$shareholder['related_party_activity'])) ?>"></div>
<div class="form-group"><label>% propiedad</label>
  <input type="number" step="0.01" name="shareholder_pct" value="<?= htmlspecialchars(v($f1,'shareholder_pct',$shareholder['ownership_percentage'])) ?>"></div>

<h3>Part IV — Transacciones monetarias (5472)</h3>
<table border="1" cellpadding="6" style="width:100%;border-collapse:collapse;">
<?php
$lineLabels = [
    '9'=>'Ventas de inventario','10'=>'Ventas de propiedad tangible','11'=>'Contribución de plataforma recibida',
    '12'=>'Reparto de costos recibido','13a'=>'Alquileres recibidos','13b'=>'Regalías recibidas',
    '14'=>'Ventas/licencias de intangibles','15'=>'Servicios técnicos recibidos','16'=>'Comisiones recibidas',
    '17b'=>'Montos prestados (saldo final)','18'=>'Intereses recibidos','19'=>'Primas de seguros recibidas',
    '20'=>'Comisiones por garantías recibidas','21'=>'Otros ingresos recibidos',
    '23'=>'Compras de inventario','24'=>'Compras de propiedad tangible','25'=>'Contribución de plataforma pagada',
    '26'=>'Reparto de costos pagado','27a'=>'Alquileres pagados','27b'=>'Regalías pagadas',
    '28'=>'Licencias/compras de intangibles','29'=>'Servicios técnicos pagados','30'=>'Comisiones pagadas',
    '31b'=>'Montos prestados (saldo final)','32'=>'Intereses pagados','33'=>'Primas de seguros pagadas',
    '34'=>'Comisiones por garantías pagadas','35'=>'Otros pagos realizados',
];
foreach ($lineLabels as $num => $label):
?>
  <tr>
    <td><?= $num ?></td><td><?= $label ?></td>
    <td><input type="number" step="0.01" name="line_<?= $num ?>" value="<?= htmlspecialchars(v($f5,'line_'.$num,0)) ?>"></td>
  </tr>
<?php endforeach; ?>
</table>

<h3>Part V — Distribución (5472)</h3>
<div class="form-group"><label>Monto distribuido al shareholder ($)</label>
  <input type="number" step="0.01" name="distribution_amount" value="<?= htmlspecialchars(v($f5,'distribution_amount',$grossPayments)) ?>"></div>
<div class="form-group"><label>Ingresos brutos de terceros ($)</label>
  <input type="number" step="0.01" name="third_party_gross_receipts" value="<?= htmlspecialchars(v($f5,'third_party_gross_receipts',0)) ?>"></div>

<h3>CSA / BEAT (opcional)</h3>
<div class="form-group"><label>Descripción CSA</label>
  <textarea name="csa_description"><?= htmlspecialchars(v($f5,'csa_description','')) ?></textarea></div>
<div class="form-group"><label>% beneficios CSA</label>
  <input type="number" step="0.01" name="csa_benefit_share" value="<?= htmlspecialchars(v($f5,'csa_benefit_share','')) ?>"></div>
<div class="form-group"><label>Pagos BEAT (59A)</label>
  <input type="number" step="0.01" name="beat_payments" value="<?= htmlspecialchars(v($f5,'beat_payments','')) ?>"></div>
<div class="form-group"><label>Beneficios fiscales BEAT</label>
  <input type="number" step="0.01" name="beat_tax_benefits" value="<?= htmlspecialchars(v($f5,'beat_tax_benefits','')) ?>"></div>

<h3>Form 1120 — Firma</h3>
<div class="form-group"><label>Nombre del firmante</label>
  <input type="text" name="signer_name" value="<?= htmlspecialchars(v($f1,'signer_name',$shareholder['name'])) ?>"></div>
<div class="form-group"><label>Cargo</label>
  <input type="text" name="signer_title" value="<?= htmlspecialchars(v($f1,'signer_title','Manager')) ?>"></div>
<div class="form-group"><label>Fecha de firma</label>
  <input type="date" name="signature_date" value="<?= htmlspecialchars(v($f1,'signature_date',date('Y-m-d'))) ?>"></div>
<div class="form-group"><label>Método contable</label>
  <select name="accounting_method">
    <option value="cash" <?= v($f1,'accounting_method','cash')==='cash'?'selected':'' ?>>Cash</option>
    <option value="accrual" <?= v($f1,'accounting_method','')==='accrual'?'selected':'' ?>>Accrual</option>
    <option value="other" <?= v($f1,'accounting_method','')==='other'?'selected':'' ?>>Other</option>
  </select></div>

<h3>Form 1120 — Ingresos / Deducciones (worksheet interno)</h3>
<?php
$moneyFields = [
  'gross_receipts'=>'Gross receipts','returns_allowances'=>'Returns/allowances','cost_of_goods_sold'=>'COGS',
  'dividends'=>'Dividends','interest_income'=>'Interest','gross_rents'=>'Gross rents','gross_royalties'=>'Gross royalties',
  'capital_gain'=>'Capital gain','other_income'=>'Other income','compensation_officers'=>'Compensation officers',
  'salaries_wages'=>'Salaries/wages','repairs_maintenance'=>'Repairs/maintenance','bad_debts'=>'Bad debts',
  'rents'=>'Rents','taxes_licenses'=>'Taxes/licenses','interest_deduction'=>'Interest ded.','charitable'=>'Charitable',
  'depreciation'=>'Depreciation','advertising'=>'Advertising','other_deductions'=>'Other deductions',
  'estimated_payments'=>'Estimated payments','tax_deposited_7004'=>'Tax deposited (7004)','withholding'=>'Withholding',
];
foreach ($moneyFields as $key => $label): ?>
<div class="form-group"><label><?= $label ?></label>
  <input type="number" step="0.01" name="<?= $key ?>" value="<?= htmlspecialchars(v($f1,$key,0)) ?>"></div>
<?php endforeach; ?>

<h3>Schedule L — Balance Sheet</h3>
<table border="1" cellpadding="6" style="width:100%;border-collapse:collapse;">
<tr><th></th><th>Inicio de año</th><th>Fin de año</th></tr>
<tr><td>Cash</td>
  <td><input type="number" step="0.01" name="cash_beginning" value="<?= htmlspecialchars(v($f1,'cash_beginning',0)) ?>"></td>
  <td><input type="number" step="0.01" name="cash_end" value="<?= htmlspecialchars(v($f1,'cash_end',0)) ?>"></td></tr>
<tr><td>Common stock</td>
  <td><input type="number" step="0.01" name="common_stock_beginning" value="<?= htmlspecialchars(v($f1,'common_stock_beginning',$commonStock)) ?>"></td>
  <td><input type="number" step="0.01" name="common_stock_end" value="<?= htmlspecialchars(v($f1,'common_stock_end',$commonStock)) ?>"></td></tr>
<tr><td>Retained earnings</td>
  <td><input type="number" step="0.01" name="retained_earnings_begin" value="<?= htmlspecialchars(v($f1,'retained_earnings_begin',0)) ?>"></td>
  <td><input type="number" step="0.01" name="retained_earnings" value="<?= htmlspecialchars(v($f1,'retained_earnings',0)) ?>"></td></tr>
</table>

<div class="form-group"><label>Distribuciones en efectivo (Schedule K)</label>
  <input type="number" step="0.01" name="cash_distributions" value="<?= htmlspecialchars(v($f1,'cash_distributions',0)) ?>"></div>

<br><button type="submit" style="padding:10px 25px;background:#F15A24;color:#fff;border:none;border-radius:5px;">
  <?= $isEdit ? 'Actualizar' : 'Guardar' ?>
</button>
</form>
</div>

<style>
.form-group{display:flex;margin-bottom:10px;}
.form-group label{flex:1;font-weight:bold;padding-right:10px;}
.form-group input,.form-group select,.form-group textarea{flex:2;padding:5px;border:1px solid #ccc;border-radius:4px;}
</style>