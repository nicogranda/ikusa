<form action="/admin/index.php?page=irs&action=1120" method="post" target="_blank" class="form-5472">
<?php
$company     = $data['company']      ?? [];
$income      = $data['income']       ?? [];
$deductions  = $data['deductions']   ?? [];
$tax         = $data['tax']          ?? [];
$balance     = $data['balance_sheet'] ?? [];
?>

<h2>Información de la Corporación</h2>

<div class="form-group">
  <label>Nombre:</label>
  <input type="text" name="corp_name" value="<?= htmlspecialchars($company['name'] ?? '') ?>">
</div>
<div class="form-group">
  <label>Dirección:</label>
  <input type="text" name="corp_address" value="<?= htmlspecialchars($company['address'] ?? '') ?>">
</div>
<div class="form-group">
  <label>Ciudad, Estado, ZIP:</label>
  <input type="text" name="corp_citystatezip"
         value="<?= htmlspecialchars(($company['city'] ?? '') . ', ' . ($company['state'] ?? '') . ' ' . ($company['zip'] ?? '')) ?>">
</div>
<div class="form-group">
  <label>EIN:</label>
  <input type="text" name="ein" value="<?= htmlspecialchars($company['ein'] ?? '') ?>">
</div>
<div class="form-group">
  <label>Fecha de incorporación:</label>
  <input type="date" name="date_incorporated" value="<?= htmlspecialchars($company['date_incorporated'] ?? '') ?>">
</div>
<div class="form-group">
  <label>Activos Totales ($):</label>
  <input type="number" step="0.01" name="total_assets" value="<?= $company['total_assets'] ?? '' ?>">
</div>
<div class="form-group">
  <label>Actividad principal:</label>
  <input type="text" name="activity" value="<?= htmlspecialchars($company['business_activity'] ?? '') ?>">
</div>
<div class="form-group">
  <label>Código de actividad:</label>
  <input type="text" name="activity_code" value="<?= htmlspecialchars($company['activity_code'] ?? '') ?>">
</div>
<div class="form-group">
  <label>Método contable:</label>
  <select name="accounting_method">
    <option value="cash"    <?= ($company['accounting_method'] ?? '') === 'cash'    ? 'selected' : '' ?>>Cash</option>
    <option value="accrual" <?= ($company['accounting_method'] ?? '') === 'accrual' ? 'selected' : '' ?>>Accrual</option>
    <option value="other"   <?= ($company['accounting_method'] ?? '') === 'other'   ? 'selected' : '' ?>>Other</option>
  </select>
</div>
<div class="form-group">
  <label>Return inicial:</label>
  <input type="checkbox" name="initial_return" value="1" <?= !empty($company['initial_return']) ? 'checked' : '' ?>>
</div>

<h2>Ingresos (Income)</h2>

<table class="transactions-table">
  <thead>
    <tr><th>Línea</th><th>Concepto</th><th>Valor ($)</th></tr>
  </thead>
  <tbody>
    <tr><td>1a</td><td>Gross receipts or sales</td>
        <td><input type="number" step="0.01" name="gross_receipts" value="<?= $income['gross_receipts'] ?? '' ?>"></td></tr>
    <tr><td>1b</td><td>Returns and allowances</td>
        <td><input type="number" step="0.01" name="returns_allowances" value="<?= $income['returns_allowances'] ?? '' ?>"></td></tr>
    <tr><td>1c</td><td>Balance (1a − 1b)</td>
        <td><input type="number" step="0.01" name="balance_1c" readonly></td></tr>
    <tr><td>2</td><td>Cost of goods sold</td>
        <td><input type="number" step="0.01" name="cost_of_goods_sold" value="<?= $income['cost_of_goods_sold'] ?? '' ?>"></td></tr>
    <tr><td>3</td><td>Gross profit (1c − 2)</td>
        <td><input type="number" step="0.01" name="gross_profit" readonly></td></tr>
    <tr><td>4</td><td>Dividends and inclusions</td>
        <td><input type="number" step="0.01" name="dividends" value="<?= $income['dividends'] ?? '' ?>"></td></tr>
    <tr><td>5</td><td>Interest</td>
        <td><input type="number" step="0.01" name="interest_income" value="<?= $income['interest'] ?? '' ?>"></td></tr>
    <tr><td>6</td><td>Gross rents</td>
        <td><input type="number" step="0.01" name="gross_rents" value="<?= $income['gross_rents'] ?? '' ?>"></td></tr>
    <tr><td>7</td><td>Gross royalties</td>
        <td><input type="number" step="0.01" name="gross_royalties" value="<?= $income['gross_royalties'] ?? '' ?>"></td></tr>
    <tr><td>8</td><td>Capital gain net income</td>
        <td><input type="number" step="0.01" name="capital_gain" value="<?= $income['capital_gain'] ?? '' ?>"></td></tr>
    <tr><td>10</td><td>Other income</td>
        <td><input type="number" step="0.01" name="other_income" value="<?= $income['other_income'] ?? '' ?>"></td></tr>
    <tr><td>11</td><td><strong>Total income (3 + 4..10)</strong></td>
        <td><input type="number" step="0.01" name="total_income" readonly></td></tr>
  </tbody>
</table>

<h2>Deducciones (Deductions)</h2>

<table class="transactions-table">
  <thead>
    <tr><th>Línea</th><th>Concepto</th><th>Valor ($)</th></tr>
  </thead>
  <tbody>
    <tr><td>12</td><td>Compensation of officers</td>
        <td><input type="number" step="0.01" name="compensation_officers" value="<?= $deductions['compensation_officers'] ?? '' ?>"></td></tr>
    <tr><td>13</td><td>Salaries and wages</td>
        <td><input type="number" step="0.01" name="salaries_wages" value="<?= $deductions['salaries_wages'] ?? '' ?>"></td></tr>
    <tr><td>14</td><td>Repairs and maintenance</td>
        <td><input type="number" step="0.01" name="repairs_maintenance" value="<?= $deductions['repairs_maintenance'] ?? '' ?>"></td></tr>
    <tr><td>15</td><td>Bad debts</td>
        <td><input type="number" step="0.01" name="bad_debts" value="<?= $deductions['bad_debts'] ?? '' ?>"></td></tr>
    <tr><td>16</td><td>Rents</td>
        <td><input type="number" step="0.01" name="rents" value="<?= $deductions['rents'] ?? '' ?>"></td></tr>
    <tr><td>17</td><td>Taxes and licenses</td>
        <td><input type="number" step="0.01" name="taxes_licenses" value="<?= $deductions['taxes_licenses'] ?? '' ?>"></td></tr>
    <tr><td>18</td><td>Interest</td>
        <td><input type="number" step="0.01" name="interest_deduction" value="<?= $deductions['interest'] ?? '' ?>"></td></tr>
    <tr><td>19</td><td>Charitable contributions</td>
        <td><input type="number" step="0.01" name="charitable" value="<?= $deductions['charitable'] ?? '' ?>"></td></tr>
    <tr><td>20</td><td>Depreciation</td>
        <td><input type="number" step="0.01" name="depreciation" value="<?= $deductions['depreciation'] ?? '' ?>"></td></tr>
    <tr><td>22</td><td>Advertising</td>
        <td><input type="number" step="0.01" name="advertising" value="<?= $deductions['advertising'] ?? '' ?>"></td></tr>
    <tr><td>26</td><td>Other deductions</td>
        <td><input type="number" step="0.01" name="other_deductions" value="<?= $deductions['other_deductions'] ?? '' ?>"></td></tr>
    <tr><td>27</td><td><strong>Total deductions</strong></td>
        <td><input type="number" step="0.01" name="total_deductions" readonly></td></tr>
    <tr><td>28</td><td><strong>Taxable income before NOL (11 − 27)</strong></td>
        <td><input type="number" step="0.01" name="taxable_income_before_nol" readonly></td></tr>
    <tr><td>30</td><td><strong>Taxable income</strong></td>
        <td><input type="number" step="0.01" name="taxable_income" readonly></td></tr>
  </tbody>
</table>

<h2>Pagos (Schedule J)</h2>

<table class="transactions-table">
  <thead>
    <tr><th>Línea</th><th>Concepto</th><th>Valor ($)</th></tr>
  </thead>
  <tbody>
    <tr><td>14</td><td>Estimated tax payments</td>
        <td><input type="number" step="0.01" name="estimated_payments" value="<?= $tax['estimated_payments'] ?? '' ?>"></td></tr>
    <tr><td>17</td><td>Tax deposited with Form 7004</td>
        <td><input type="number" step="0.01" name="tax_deposited_7004" value="<?= $tax['tax_deposited_7004'] ?? '' ?>"></td></tr>
    <tr><td>18</td><td>Withholding</td>
        <td><input type="number" step="0.01" name="withholding" value="<?= $tax['withholding'] ?? '' ?>"></td></tr>
  </tbody>
</table>

<h2>Balance Sheet (Schedule L)</h2>

<table class="transactions-table">
  <thead>
    <tr><th>Concepto</th><th>Inicio año</th><th>Fin año</th></tr>
  </thead>
  <tbody>
    <tr>
      <td>Cash</td>
      <td><input type="number" step="0.01" name="cash_beginning" value="<?= $balance['cash_beginning'] ?? '' ?>"></td>
      <td><input type="number" step="0.01" name="cash_end" value="<?= $balance['cash_end'] ?? '' ?>"></td>
    </tr>
    <tr>
      <td>Total assets</td>
      <td><input type="number" step="0.01" name="total_assets_beginning" value="<?= $balance['total_assets_beginning'] ?? '' ?>"></td>
      <td><input type="number" step="0.01" name="total_assets_end" value="<?= $balance['total_assets_end'] ?? '' ?>"></td>
    </tr>
    <tr>
      <td>Retained earnings</td>
      <td><input type="number" step="0.01" name="retained_earnings_beginning" value="0"></td>
      <td><input type="number" step="0.01" name="retained_earnings" value="<?= $balance['retained_earnings'] ?? '' ?>"></td>
    </tr>
  </tbody>
</table>

<button type="submit">Generar Form 1120 PDF</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {

  function val(name) {
    return parseFloat(document.querySelector(`[name="${name}"]`)?.value) || 0;
  }

  function set(name, value) {
    const el = document.querySelector(`[name="${name}"]`);
    if (el) el.value = value.toFixed(2);
  }

  function calculate() {
    const balance1c = val('gross_receipts') - val('returns_allowances');
    set('balance_1c', balance1c);

    const grossProfit = balance1c - val('cost_of_goods_sold');
    set('gross_profit', grossProfit);

    const totalIncome = grossProfit + val('dividends') + val('interest_income') +
                        val('gross_rents') + val('gross_royalties') +
                        val('capital_gain') + val('other_income');
    set('total_income', totalIncome);

    const totalDeductions = val('compensation_officers') + val('salaries_wages') +
                            val('repairs_maintenance') + val('bad_debts') +
                            val('rents') + val('taxes_licenses') +
                            val('interest_deduction') + val('charitable') +
                            val('depreciation') + val('advertising') +
                            val('other_deductions');
    set('total_deductions', totalDeductions);

    const taxableBeforeNol = totalIncome - totalDeductions;
    set('taxable_income_before_nol', taxableBeforeNol);
    set('taxable_income', taxableBeforeNol);
  }

  document.querySelectorAll('input[type="number"]:not([readonly])').forEach(el => {
    el.addEventListener('input', calculate);
  });

  calculate();
});
</script>