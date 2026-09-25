<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../../vendor/autoload.php';
use setasign\Fpdi\Tcpdf\Fpdi;

$fiscal_status = $_POST['fiscal_status'] ?? 'foreign_disregarded_llc';

// ── Datos del POST ────────────────────────────────
$corp_name         = $_POST['corp_name']         ?? 'Ikusa LLC';
$corp_address      = $_POST['corp_address']      ?? '8735 Dunwoody Place, Ste R';
$corp_citystatezip = $_POST['corp_citystatezip'] ?? 'Atlanta, GA 30350';
$ein               = $_POST['ein']               ?? '87-2680481';
$date_incorporated = $_POST['date_incorporated'] ?? '08/31/2021';
$activity          = $_POST['activity']          ?? 'Marketing and web development services';
$products          = $_POST['products']          ?? 'Digital marketing, website design, and graphic design';
$activity_code     = $_POST['activity_code']     ?? '541800';

$accounting_method = $_POST['accounting_method'] ?? 'cash';

// ── Balance sheet — beginning of year (= end of 2024) ─
$cash_beginning          = floatval($_POST['cash_beginning']          ??    6.08);
$common_stock_beginning  = floatval($_POST['common_stock_beginning']  ?? 3000.00);
$retained_earnings_begin = floatval($_POST['retained_earnings_begin'] ??  -13.83);
$total_assets_beginning  = $cash_beginning + $common_stock_beginning + $retained_earnings_begin;

// ── Balance sheet — end of year (= end of 2025) ───────
$cash_end                = floatval($_POST['cash_end']                ??   36.91);
$common_stock_end        = floatval($_POST['common_stock_end']        ?? 3000.00);
$retained_earnings       = floatval($_POST['retained_earnings']       ??  205.99);
$total_assets_end        = $cash_end + $common_stock_end + $retained_earnings;

// ── Ingresos ──────────────────────────────────────────
$gross_receipts     = floatval($_POST['gross_receipts']     ?? 0);
$returns_allowances = floatval($_POST['returns_allowances'] ?? 0);
$cost_goods_sold    = floatval($_POST['cost_of_goods_sold'] ?? 0);
$dividends          = floatval($_POST['dividends']          ?? 0);
$interest_income    = floatval($_POST['interest_income']    ?? 0);
$gross_rents        = floatval($_POST['gross_rents']        ?? 0);
$gross_royalties    = floatval($_POST['gross_royalties']    ?? 0);
$capital_gain       = floatval($_POST['capital_gain']       ?? 0);
$other_income       = floatval($_POST['other_income']       ?? 0);

// ── Deducciones ───────────────────────────────────────
$compensation_officers = floatval($_POST['compensation_officers'] ?? 0);
$salaries_wages        = floatval($_POST['salaries_wages']        ?? 0);
$repairs_maintenance   = floatval($_POST['repairs_maintenance']   ?? 0);
$bad_debts             = floatval($_POST['bad_debts']             ?? 0);
$rents                 = floatval($_POST['rents']                 ?? 0);
$taxes_licenses        = floatval($_POST['taxes_licenses']        ?? 0);
$interest_ded          = floatval($_POST['interest_deduction']    ?? 0);
$charitable            = floatval($_POST['charitable']            ?? 0);
$depreciation          = floatval($_POST['depreciation']          ?? 0);
$advertising           = floatval($_POST['advertising']           ?? 0);
$other_deductions      = floatval($_POST['other_deductions']      ?? 0);

// ── Pagos ─────────────────────────────────────────────
$estimated_payments = floatval($_POST['estimated_payments'] ?? 0);
$tax_deposited_7004 = floatval($_POST['tax_deposited_7004'] ?? 0);
$withholding        = floatval($_POST['withholding']        ?? 0);

// ── Cálculos ──────────────────────────────────────────
$is_disregarded_llc = true;

$balance_1c         = $gross_receipts - $returns_allowances;
$gross_profit       = $balance_1c - $cost_goods_sold;

$total_income       = $gross_profit + $dividends + $interest_income
                    + $gross_rents + $gross_royalties + $capital_gain + $other_income;

$total_deductions   = $compensation_officers + $salaries_wages + $repairs_maintenance
                    + $bad_debts + $rents + $taxes_licenses + $interest_ded
                    + $charitable + $depreciation + $advertising + $other_deductions;

$taxable_before_nol = $total_income - $total_deductions;
$taxable_income     = $taxable_before_nol;

$total_tax          = 0;
$amount_owed        = 0;
$overpayment        = 0;
$total_payments     = $estimated_payments + $tax_deposited_7004 + $withholding;

// ── Helpers ───────────────────────────────────────────
function f($val) {
    return $val != 0 ? number_format(abs($val), 2) : '';
}

function writeRight($pdf, $xRight, $y, $text, $maxWidth = 35) {
    if ($text === '') return;
    $pdf->SetXY($xRight - $maxWidth, $y);
    $pdf->Cell($maxWidth, 4, $text, 0, 0, 'R');
}

// ── TCPDF + FPDI ──────────────────────────────────
$pdf = new Fpdi();
$pdf->setCreator(PDF_CREATOR);
// $pdf->setAuthor('Nicolas Granda');
$pdf->setAuthor('Foreign-Owned LLC Compliance Generator');
$pdf->setTitle('IRS Form 1120 (Pro-Forma) + Form 5472 - Foreign-Owned LLC');
$pdf->setSubject('irs');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdfPath = __DIR__ . '/1120_compat.pdf';
$pageCount = $pdf->setSourceFile($pdfPath);

$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(false, 0);

// ── COORDINATE REFERENCE (calibrated from pdfplumber) ──
// X columns (mm):
//   $xName  = 56.0   — left text fields (name, address, city)
//   $xEIN   = 181.0  — right header column (EIN, date, assets)
//   $xL1a   = 151.0  — line 1a sub-box (gross receipts)
//   $xR     = 181.0  — main right value column (all other amounts)
//   $xRight = 197.0  — right edge for right-aligned numbers
//
// Y rows (mm) = pdfplumber_top_pt × 0.3528:
//   All values below are exact from pdfplumber analysis.

for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $pdf->AddPage('P', 'LETTER');
    $templateId = $pdf->importPage($pageNo);
    $size = $pdf->getTemplateSize($templateId);
    $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

    $pdf->SetFont('Helvetica', '', 9);

    // ══════════════════════════════════════════════════════════
    // PÁGINA 1 — Income & Deductions
    // ══════════════════════════════════════════════════════════
    if ($pageNo === 1) {
     $yDate = 17.5;
    // Tax year
    $pdf->SetXY(100, $yDate); $pdf->Write(0, 'January');
   
    $pdf->SetXY(143, $yDate); $pdf->Write(0, 'December');
    $pdf->SetXY(165, $yDate); $pdf->Write(0, '25');
    
        // ── Column X positions ─────────────────────────────
        $xName  = 56.0;   // Left text area
        $xEIN   = 181.0;  // Right header column
        $xL1a   = 151.0;  // 1a sub-box
        $xRight = 197.0;  // Right edge for right-aligned numbers
        $colW   = 35;     // Column width for right-aligned cells

        // ── Header Y positions (mm) ────────────────────────
        // pdfplumber: name=81pt, address=109.4pt, city=132.1pt
        $yName    = 28.6;  // 81.0 × 0.3528
        $yAddress = 38.6;  // 109.4 × 0.3528
        $yCity    = 46.6;  // 132.1 × 0.3528

        // Entity info
        $pdf->SetXY($xName, $yName);    $pdf->Write(0, $corp_name);
        $pdf->SetXY($xName, $yAddress); $pdf->Write(0, $corp_address);
        $pdf->SetXY($xName, $yCity);    $pdf->Write(0, 'Atlanta');
        $pdf->SetXY(81.0,   $yCity);    $pdf->Write(0, 'Georgia');
        $pdf->SetXY(112.0,  $yCity);    $pdf->Write(0, 'United States');
        $pdf->SetXY(141.0,  $yCity);    $pdf->Write(0, '30350');

        $pdf->SetXY($xEIN, $yName);    $pdf->Write(0, $ein);
        $pdf->SetXY($xEIN, $yAddress); $pdf->Write(0, $date_incorporated);
        $pdf->SetXY($xEIN, $yCity); $pdf->Write(0, f($total_assets_end));

        // Cash accounting checkbox (pdfplumber: top=161.2pt → 56.9mm, x=107.7pt → 38.0mm)
        // $pdf->SetFont('dejavusans', '', 12);
        // $pdf->SetXY(38.0, 56.9);
        // $pdf->Write(0, '✓');
        $pdf->SetFont('Helvetica', '', 9);

        // ── Income Y positions (pdfplumber top × 0.3528) ───
        // Line 1a: gross receipts goes in sub-box at x=428pt=151mm
        // Lines 1c onward: full right column at x=513pt=181mm
        $y1a  = 56.2;   // 159.4pt
        $y1b  = 60.5;   // 171.4pt
        $y1c  = 64.7;   // 183.4pt
        $y2   = 68.9;   // 195.4pt
        $y3   = 73.2;   // 207.4pt
        $y4   = 77.4;   // 219.4pt
        $y5   = 81.6;   // 231.4pt
        $y6   = 85.9;   // 243.4pt
        $y7   = 90.1;   // 255.4pt
        $y8   = 94.3;   // 267.4pt
        $y9   = 98.6;   // 279.4pt
        $y10  = 102.8;  // 291.4pt
        $y11  = 107.0;  // 303.3pt

        // Line 1a: right-aligned in its own sub-column (right edge ≈ 163mm)
        if ($gross_receipts)     { writeRight($pdf, 163.0, $y1a, f($gross_receipts)); }
        // Lines 1b uses same sub-column as 1a
        if ($returns_allowances) { writeRight($pdf, 163.0, $y1b, f($returns_allowances)); }
        // Lines 1c onward use full right column
        if ($balance_1c)         { writeRight($pdf, $xRight, $y1c, f($balance_1c)); }
        if ($cost_goods_sold)    { writeRight($pdf, $xRight, $y2,  f($cost_goods_sold)); }
        if ($gross_profit)       { writeRight($pdf, $xRight, $y3,  f($gross_profit)); }
        if ($dividends)          { writeRight($pdf, $xRight, $y4,  f($dividends)); }
        if ($interest_income)    { writeRight($pdf, $xRight, $y5,  f($interest_income)); }
        if ($gross_rents)        { writeRight($pdf, $xRight, $y6,  f($gross_rents)); }
        if ($gross_royalties)    { writeRight($pdf, $xRight, $y7,  f($gross_royalties)); }
        if ($capital_gain)       { writeRight($pdf, $xRight, $y8,  f($capital_gain)); }
        if ($other_income)       { writeRight($pdf, $xRight, $y10, f($other_income)); }
        if ($total_income)       { writeRight($pdf, $xRight, $y11, f($total_income)); }

        // ── Deductions Y positions ─────────────────────────
        $y12  = 111.3;  // 315.4pt
        $y13  = 115.5;  // 327.5pt
        $y14  = 119.7;  // 339.4pt
        $y15  = 124.0;  // 351.4pt
        $y16  = 128.2;  // 363.4pt
        $y17  = 132.4;  // 375.4pt
        $y18  = 136.7;  // 387.4pt
        $y19  = 140.9;  // 399.4pt
        $y20  = 145.1;  // 411.4pt
        // line 21 = depletion (skip)
        $y22  = 153.6;  // 435.4pt — Advertising
        // lines 23-25 (pension, benefits, energy) — skip if unused
        $y26  = 170.5;  // 483.4pt — Other deductions
        $y27  = 174.7;  // 495.3pt — Total deductions
        $y28  = 179.0;  // 507.4pt — Taxable income before NOL
        // 29a, 29b, 29c — NOL (skip for IKUSA)
        $y30  = 195.9;  // 555.4pt — Taxable income
        $y31  = 200.2;  // 567.4pt — Total tax
        // 32 = section 1062 (skip)
        $y33  = 208.6;  // 591.4pt — Total payments
        // 34 = penalty (skip)
        $y35  = 217.1;  // 615.3pt — Amount owed
        $y36  = 221.3;  // 627.3pt — Overpayment
        $y37b = 225.5;  // 639.3pt — Refunded

        if ($compensation_officers) { writeRight($pdf, $xRight, $y12, f($compensation_officers)); }
        if ($salaries_wages)        { writeRight($pdf, $xRight, $y13, f($salaries_wages)); }
        if ($repairs_maintenance)   { writeRight($pdf, $xRight, $y14, f($repairs_maintenance)); }
        if ($bad_debts)             { writeRight($pdf, $xRight, $y15, f($bad_debts)); }
        if ($rents)                 { writeRight($pdf, $xRight, $y16, f($rents)); }
        if ($taxes_licenses)        { writeRight($pdf, $xRight, $y17, f($taxes_licenses)); }
        if ($interest_ded)          { writeRight($pdf, $xRight, $y18, f($interest_ded)); }
        if ($charitable)            { writeRight($pdf, $xRight, $y19, f($charitable)); }
        if ($depreciation)          { writeRight($pdf, $xRight, $y20, f($depreciation)); }
        if ($advertising)           { writeRight($pdf, $xRight, $y22, f($advertising)); }
        if ($other_deductions)      { writeRight($pdf, $xRight, $y26, f($other_deductions)); }
        if ($total_deductions)      { writeRight($pdf, $xRight, $y27, f($total_deductions)); }
        if ($taxable_before_nol)    { writeRight($pdf, $xRight, $y28, f($taxable_before_nol)); }
        if ($taxable_income)        { writeRight($pdf, $xRight, $y30, f($taxable_income)); }
        if ($total_tax)             { writeRight($pdf, $xRight, $y31, f($total_tax)); }
        if ($total_payments)        { writeRight($pdf, $xRight, $y33, f($total_payments)); }
        if ($amount_owed)           { writeRight($pdf, $xRight, $y35, f($amount_owed)); }
        if ($overpayment)           { writeRight($pdf, $xRight, $y36, f($overpayment)); }
        if ($overpayment)           { writeRight($pdf, $xRight, $y37b, f($overpayment)); }

        // ── Sign area ──────────────────────────────────────
        // Title: pdfplumber top=693.3pt → 244.6mm, x≈328pt → 115.7mm
        $pdf->SetXY(95.0, 244.6);
        $pdf->Write(0, '06-12-2025');
        $pdf->SetXY(115.0, 244.6);
        $pdf->Write(0, 'Manager');
        // Preparer name: pdfplumber top=727.3pt → 256.6mm, x=99.2pt → 35.0mm
        $pdf->SetXY(35.0, 256.6);
        $pdf->Write(0, 'Nicolas Granda Bauza');
    }

    // ══════════════════════════════════════════════════════════
    // PÁGINAS 2 y 3 — Solo firma/nombre en cada página
    // ══════════════════════════════════════════════════════════
    // if ($pageNo === 2 || $pageNo === 3) {
    //     $pdf->SetXY(115.0, 244.6);
    //     $pdf->Write(0, 'Manager');
    //     $pdf->SetXY(35.0, 256.6);
    //     $pdf->Write(0, 'Nicolas Granda Bauza');
    // }



    // ══════════════════════════════════════════════════════════
    // PÁGINA 4 — Schedule K Other Information
    // ══════════════════════════════════════════════════════════
    if ($pageNo === 4) {

        // Accounting method: Cash checkbox
        // pdfplumber: ✓ at x≈107pt=37.8mm, need to verify actual position
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->SetXY(63.0, 20.0);
        $pdf->Write(0, '✓');
        $pdf->SetFont('Helvetica', '', 9);

        // Activity code & description (Q2)
        $pdf->SetXY(65.0, 30.0);
        $pdf->Write(0, $activity_code);
        $pdf->SetXY(45.0, 33.5);
        $pdf->Write(0, $activity);
        
        // $pdf->SetXY(46.5, 37.5);
        // $pdf->Write(0, $products);

       // Q3: No
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->SetXY(197.5, 42.5);
        $pdf->Write(0, '✓');

        // // Q4a: 
        // $pdf->SetFont('dejavusans', '', 12);
        // $pdf->SetXY(197.5, 67.5);
        // $pdf->Write(0, '✓');
        
        
        // Q4b: individual owns 50%+ → Yes
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->SetXY(190.0, 77.5);
        $pdf->Write(0, '✓');
        
       // Q5a: 
        // $pdf->SetFont('dejavusans', '', 12);
        // $pdf->SetXY(197.5, 92.5);
        // $pdf->Write(0, '✓');
        
        // Q5b: 
        // $pdf->SetFont('dejavusans', '', 12);
        // $pdf->SetXY(197.5, 142.5);
        // $pdf->Write(0, '✓');

        // Q6: foreign person owns 25%+ → Yes
        $pdf->SetXY(197.5, 192.5);
        $pdf->Write(0, '✓');
        
         // Q7  
        $pdf->SetXY(190.0, 207.5);
        $pdf->Write(0, '✓');
        $pdf->SetFont('Helvetica', '', 9);

        // Q7 details: percentage and country
        $pdf->SetXY(56.0, 217.5);
        $pdf->Write(0, '100%');
        $pdf->SetXY(112.0, 217.5);
        $pdf->Write(0, 'Spain');

        // Number of Forms 5472 attached (Q7c)
        $pdf->SetXY(178.0, 227.5); $pdf->Write(0, '1');
        
        // Q10: number of shareholders
        $pdf->SetXY(178.0, 243.0); $pdf->Write(0, '1');

    }
    // ══════════════════════════════════════════════════════════
    // PÁGINA 5 — Schedule K (continued)
    // ══════════════════════════════════════════════════════════
    if ($pageNo === 5) {
    
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->SetTextColor(0, 0, 0);
    
        // ------------------------------------------------------
        // Q13
        // Total receipts < $250,000 y assets < $250,000
        // YES
        // ------------------------------------------------------
        $pdf->SetXY(190.0, 25.0);
        $pdf->Write(0, '✓');
    
        // Cash distributions amount
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY(165.0, 35.0);
        $pdf->Write(0, '205.99');
    
        $pdf->SetFont('dejavusans', '', 12);
    
        // Columna NO
        $xYes = 190.0;
        $xNo = 197.5;
    
        // ------------------------------------------------------
        // Q14
        // Schedule UTP required?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 37);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q15a
        // Payments requiring Form 1099?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 45);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q15b
        // Required Forms 1099 filed?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 50);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q16
        // 80% or greater ownership change?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 57.5);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q17
        // Disposal of >65% of assets?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 67);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q18
        // Section 351 transfer?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 77);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q19
        // Payments requiring Forms 1042 / 1042-S?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 82);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q20
        // Cooperative basis?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 87.5);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q21
        // Interest/Royalty deduction disallowed under 267A?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 97.5);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q22
        // Gross receipts >= $500 million?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 105);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q23
        // Election under section 163(j)?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 118);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q24
        // Form 8990 required?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 122);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q24c
        // Tax shelter with business interest expense?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 142);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q25
        // Qualified Opportunity Fund?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 162);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q26
        // Foreign corporation acquisition?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 175);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q27
        // Digital assets received/sold?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 180.0);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q28
        // Member of controlled group?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 192.5);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q29a
        // Corporate Alternative Minimum Tax
        // Applicable corporation in prior year?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 202.5);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q29b
        // Applicable corporation in current year?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 217.5);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q29c
        // Safe harbor method requirements met?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 230);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q30a
        // Form 7208 - Covered corporation stock repurchase?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 233);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q30b
        // Form 7208 - Applicable foreign corporation?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 237.5);
        $pdf->Write(0, '✓');
    
        // ------------------------------------------------------
        // Q31
        // Consolidated return > $1 billion receipts?
        // NO
        // ------------------------------------------------------
        $pdf->SetXY($xNo, 252.5);
        $pdf->Write(0, '✓');
    }


    // ══════════════════════════════════════════════════════════
    // PÁGINA 6 — Schedule L, M-1, M-2
    // ══════════════════════════════════════════════════════════
    
    if ($pageNo === 6) {
    
        $pdf->SetFont('Helvetica', '', 9);
    
        $xBA = 70.0;    // Col (a) beginning — valores sin alinear derecha
        $xBR = 142.5;   // Col (b) right edge
        $xCA = 150.0;   // Col (c) end — valores sin alinear derecha  
        $xDR = 200.0;   // Col (d) right edge
    
    
        $yL1 = 26.5;
        $yL15 = 102.6;
        $yL22b = 140.5;  
        $yL25 = 153;   
        $yL28 = 165;   
    
        // ── Schedule L: Assets ────────────────────────────────
        // L1 Cash
        writeRight($pdf, $xBR, $yL1, f($cash_beginning));
        writeRight($pdf, $xDR, $yL1, f($cash_end));
    
        // L15 Total assets
        writeRight($pdf, $xBR, $yL15, f($total_assets_beginning));
        writeRight($pdf, $xDR, $yL15, f($total_assets_end));
        
        // L22b Common stock
        writeRight($pdf, $xBR, $yL22b, f($common_stock_beginning));
        writeRight($pdf, $xDR, $yL22b, f($common_stock_end));
        
        // L25 Retained earnings — con paréntesis si negativo
        $re_begin_fmt = $retained_earnings_begin < 0 ? '(' . f($retained_earnings_begin) . ')' : f($retained_earnings_begin);
        $re_end_fmt   = $retained_earnings < 0       ? '(' . f($retained_earnings) . ')'       : f($retained_earnings);
        writeRight($pdf, $xBR, $yL25, $re_begin_fmt);
        writeRight($pdf, $xDR, $yL25, $re_end_fmt);

        // L28 Total
        writeRight($pdf, $xBR, $yL28, f($total_assets_beginning));
        writeRight($pdf, $xDR, $yL28, f($total_assets_end));
    
    
        $xBR = 105;
        
        // ── Schedule M-1 ──────────────────────────────────────
        // M1-L1 Net income per books
        writeRight($pdf, $xBR, 179.0, f($taxable_income));
        
        // M1-L6 Add lines 1-5 / M1-L10 Income page 1 line 28
        writeRight($pdf, $xBR, 229.6, f($taxable_income));
        writeRight($pdf, $xDR, 229.6, f($taxable_income));
        
        // ── Schedule M-2 ──────────────────────────────────────
        // M2-L1 Balance at beginning of year
        $m2_begin_fmt = $retained_earnings_begin < 0
            ? '(' . f($retained_earnings_begin) . ')'
            : f($retained_earnings_begin);
        writeRight($pdf, $xBR, 237.0, $m2_begin_fmt);
        
        // M2-L2 Net income per books
        writeRight($pdf, $xBR, 242.5, f($taxable_income));
        
        // M2-L4 Add lines 1,2,3
        $m2_l4 = $retained_earnings_begin + $taxable_income;
        $m2_l4_fmt = $m2_l4 < 0 ? '(' . f($m2_l4) . ')' : f($m2_l4);
        writeRight($pdf, $xBR, 259.3, $m2_l4_fmt);
        
        // M2-L8 Balance end of year = M2-L4 (sin distribuciones)
        $m2_l8 = $retained_earnings_begin + $taxable_income;
        writeRight($pdf, $xDR, 259.3, f($m2_l8));
    }
}

$pdf->Output('Form1120_2025.pdf', 'I');