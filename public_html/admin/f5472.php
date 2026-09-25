<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../vendor/autoload.php';
use setasign\Fpdi\Tcpdf\Fpdi;

// ── Datos del POST ────────────────────────────────
$corp_name         = $_POST['corp_name']          ?? 'Ikusa LLC';
$corp_address      = $_POST['corp_address']        ?? '8735 Dunwoody Place, Ste R';
$corp_citystatezip = $_POST['corp_citystatezip']   ?? 'Atlanta, GA 30350';
$ein               = $_POST['ein']                 ?? '87-2680481';
$total_assets = floatval(3242.90);
$activity          = $_POST['activity']            ?? 'Marketing and web development services';
$activity_code     = $_POST['activity_code']       ?? '541800';
$country_incorp    = $_POST['country_incorp']      ?? 'US';
$date_incorp       = $_POST['date_incorp']         ?? '2021-08-31';
$gross_payments    = floatval($_POST['gross_payments_form'] ?? 0);

$shareholder_name        = $_POST['shareholder_name']        ?? 'Nicolas Granda Bauza - Calle General Freire, 5 Piso 2 Apartamento A Irun, 20303, Guipuzcoa, Spain';
$shareholder_country     = $_POST['shareholder_country']     ?? 'ES';
$shareholder_ftin        = $_POST['shareholder_ftin']        ?? 'Z0773740W';
$shareholder_ref_id      = '27-000-001';
$shareholder_tax_country = $_POST['shareholder_tax_country'] ?? 'ES';

// Líneas monetarias
$line_9   = floatval($_POST['line_9']   ?? 0);
$line_10  = floatval($_POST['line_10']  ?? 0);
$line_11  = floatval($_POST['line_11']  ?? 0);
$line_12  = floatval($_POST['line_12']  ?? 0);
$line_13a = floatval($_POST['line_13a'] ?? 0);
$line_13b = floatval($_POST['line_13b'] ?? 0);
$line_14  = floatval($_POST['line_14']  ?? 0);
$line_15  = floatval($_POST['line_15']  ?? 0);
$line_16  = floatval($_POST['line_16']  ?? 0);
$line_17b = floatval($_POST['line_17b'] ?? 0);
$line_18  = floatval($_POST['line_18']  ?? 0);
$line_19  = floatval($_POST['line_19']  ?? 0);
$line_20  = floatval($_POST['line_20']  ?? 0);
$line_21  = floatval($_POST['line_21']  ?? 0);
$line_22  = $line_9 + $line_10 + $line_11 + $line_12 + $line_13a + $line_13b
           + $line_14 + $line_15 + $line_16 + $line_17b + $line_18 + $line_19
           + $line_20 + $line_21;

$line_23  = floatval($_POST['line_23']  ?? 0);
$line_24  = floatval($_POST['line_24']  ?? 0);
$line_25  = floatval($_POST['line_25']  ?? 0);
$line_26  = floatval($_POST['line_26']  ?? 0);
$line_27a = floatval($_POST['line_27a'] ?? 0);
$line_27b = floatval($_POST['line_27b'] ?? 0);
$line_28  = floatval($_POST['line_28']  ?? 0);
$line_29  = floatval($_POST['line_29']  ?? 0);
$line_30  = floatval($_POST['line_30']  ?? 0);
$line_31b = floatval($_POST['line_31b'] ?? 0);
$line_32  = floatval($_POST['line_32']  ?? 0);
$line_33  = floatval($_POST['line_33']  ?? 0);
$line_34  = floatval($_POST['line_34']  ?? 0);
$line_35  = floatval($_POST['line_35']  ?? 0);
$line_36  = $line_23 + $line_24 + $line_25 + $line_26 + $line_27a + $line_27b
           + $line_28 + $line_29 + $line_30 + $line_31b + $line_32 + $line_33
           + $line_34 + $line_35;

function fmt($val) {
    return $val != 0 ? number_format($val, 2) : '';
}

// ── TCPDF + FPDI ──────────────────────────────────
$pdf = new Fpdi();
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Nicolas Granda');
$pdf->setTitle('IRS Form 5472 - 2025');
$pdf->setSubject('irs');
$pdf->setKeywords('TCPDF, PDF, 5472, irs');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdfPath = __DIR__ . '/5472.pdf';
$pageCount = $pdf->setSourceFile($pdfPath);

$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(false, 0);

for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $pdf->AddPage('P', 'LETTER');
    $templateId = $pdf->importPage($pageNo);
    $size = $pdf->getTemplateSize($templateId);
    $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

    // ── PÁGINA 1 — Corporación y Shareholder ──────
if ($pageNo === 1) {
    $pdf->SetFont('Helvetica', '', 9);

    // Tax year
    $pdf->SetXY(100, 29); $pdf->Write(0, 'January');
    $pdf->SetXY(120, 29); $pdf->Write(0, '2025');
    $pdf->SetXY(143, 29); $pdf->Write(0, 'December');
    $pdf->SetXY(163, 29); $pdf->Write(0, '2025');

    // Part I
    $pdf->SetXY(15, 45);    $pdf->Write(0, $corp_name);
    $pdf->SetXY(170, 45);   $pdf->Write(0, $ein);
    $pdf->SetXY(15, 54);    $pdf->Write(0, $corp_address);
    $pdf->SetXY(15, 63);    $pdf->Write(0, $corp_citystatezip);
    $pdf->SetXY(55, 67.5);  $pdf->Write(0, $activity);
    $pdf->SetXY(180, 67.5); $pdf->Write(0, $activity_code);

    // 1c Total assets
    $pdf->SetXY(168, 62); $pdf->Write(0, number_format($total_assets, 2));
    

    // 1f y 1h — total transacciones reportables
     $pdf->SetXY(20, 80);  $pdf->Write(0, '3,586.63');
    $pdf->SetXY(100, 80); $pdf->Write(0, '1');
    $pdf->SetXY(155, 80); $pdf->Write(0, '3,586.63');

    // 1l country of incorporation
    $pdf->SetXY(168, 90); $pdf->Write(0, 'US');

    // 1m date of incorporation
    $pdf->SetXY(15, 104); $pdf->Write(0, '08/31/2021');

    // 1o countries business conducted
    $pdf->SetXY(150, 105); $pdf->Write(0, 'United States, Spain');

    // Checkboxes 2 y 3 — SIN surrogate foreign
    $pdf->SetFont('dejavusans', '', 16);
    $pdf->SetXY(197, 113); $pdf->Write(0, '✓'); // line 2
    $pdf->SetXY(197, 121); $pdf->Write(0, '✓'); // line 3
    // $pdf->SetXY(96, 133.5) — ELIMINADO (surrogate foreign)

    // Part II — Shareholder
    $pdf->SetFont('Helvetica', '', 8);
    $pdf->SetXY(15, 143);
    $pdf->Write(0, 'Nicolas Granda Bauza - Calle General Freire, 5 Piso 2 Apt A, Irun, 20303, Guipuzcoa, Spain');

    $pdf->SetFont('Helvetica', '', 9);
    $pdf->SetXY(15, 155);  $pdf->Write(0, $shareholder_ref_id);
    $pdf->SetXY(70, 155);  $pdf->Write(0, $shareholder_ref_id);
    $pdf->SetXY(148, 155); $pdf->Write(0, $shareholder_ftin);

    $pdf->SetXY(15, 167);  $pdf->Write(0, 'Spain');
    $pdf->SetXY(70, 167);  $pdf->Write(0, 'Spain');
    $pdf->SetXY(148, 167); $pdf->Write(0, 'Spain');
}

    // ── PÁGINA 2 — Part III y Part IV ─────────────
if ($pageNo === 2) {
    $pdf->SetFont('Helvetica', '', 9);

    // Part III — Related Party
    $pdf->SetXY(15, 28);  $pdf->Write(0, $shareholder_name);
    $pdf->SetXY(15, 37);  $pdf->Write(0, $shareholder_ref_id);
    $pdf->SetXY(80, 37);  $pdf->Write(0, $shareholder_ftin);
    $pdf->SetXY(55, 42.5);  $pdf->Write(0, 'Advertising and management services');
    $pdf->SetXY(180, 42.5); $pdf->Write(0, $activity_code);
    $pdf->SetXY(15, 57);  $pdf->Write(0, 'Spain'); // 8f
    $pdf->SetXY(115, 57); $pdf->Write(0, 'Spain'); // 8g

    // Part IV — en blanco para foreign-owned DE (no aplica)
    // Part V — ✓ check (reportable transactions para foreign-owned U.S. DE)
    $pdf->SetFont('dejavusans', '', 12);
    $pdf->SetXY(192, 233); $pdf->Write(0, '✓');
}
}
// ── PÁGINA 4 — Part V Statement ───────────────────
$pdf->AddPage('P', 'LETTER');
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->SetXY(15, 20);
$pdf->Write(0, 'Form 5472 — Part V Statement');

$pdf->SetFont('Helvetica', '', 9);
$pdf->SetXY(15, 30);
$pdf->Write(0, 'Reporting Corporation: Ikusa LLC');
$pdf->SetXY(15, 36);
$pdf->Write(0, 'EIN: 87-2680481');
$pdf->SetXY(15, 42);
$pdf->Write(0, 'Tax Year: January 1, 2025 – December 31, 2025');

$pdf->SetXY(15, 55);
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->Write(0, 'Reportable Transactions (Part V — Foreign-Owned U.S. Disregarded Entity)');

$pdf->SetFont('Helvetica', '', 9);
$pdf->SetXY(15, 65);
$pdf->MultiCell(180, 6,
    'During tax year 2025, Ikusa LLC, a foreign-owned U.S. disregarded entity treated as a ' .
    'corporation for purposes of section 6038A, engaged in the following reportable transactions ' .
    'with its sole foreign owner, Nicolas Granda Bauza (Spanish citizen, NIF: Z0773740W):' .
    "\n\n" .
    '1. Gross revenues received from third-party clients for marketing and web development ' .
    'services: $4,337.18' .
    "\n\n" .
    '2. Distributions made to foreign owner Nicolas Granda Bauza: $3,586.63' .
    "\n\n" .
    'All transactions were conducted at arm\'s length and in the ordinary course of business.',
    0, 'L'
);
$pdf->Output('Form5472_2025.pdf', 'I');