<?php
// app/views/admin/irs/1120/pdf.php
// Variables disponibles: $filing, $form (fila de form_1120)

require_once dirname(__DIR__, 7) . '/vendor/autoload.php';
use setasign\Fpdi\Tcpdf\Fpdi;

function f($val) {
    $val = (float)($val ?? 0);
    return $val != 0 ? number_format(abs($val), 2) : '';
}

function writeRight($pdf, $xRight, $y, $text, $maxWidth = 35) {
    if ($text === '') return;
    $pdf->SetXY($xRight - $maxWidth, $y);
    $pdf->Cell($maxWidth, 4, $text, 0, 0, 'R');
}

$taxYear = $filing['tax_year'];

// ── Cálculos derivados (igual que el script original) ──
$totalAssetsBeginning = (float)$form['cash_beginning'] + (float)$form['common_stock_beginning'] + (float)$form['retained_earnings_begin'];
$totalAssetsEnd       = (float)$form['cash_end'] + (float)$form['common_stock_end'] + (float)$form['retained_earnings'];

$balance1c   = (float)$form['gross_receipts'] - (float)$form['returns_allowances'];
$grossProfit = $balance1c - (float)$form['cost_of_goods_sold'];

$totalIncome = $grossProfit + (float)$form['dividends'] + (float)$form['interest_income']
             + (float)$form['gross_rents'] + (float)$form['gross_royalties']
             + (float)$form['capital_gain'] + (float)$form['other_income'];

$totalDeductions = (float)$form['compensation_officers'] + (float)$form['salaries_wages']
                  + (float)$form['repairs_maintenance'] + (float)$form['bad_debts']
                  + (float)$form['rents'] + (float)$form['taxes_licenses']
                  + (float)$form['interest_deduction'] + (float)$form['charitable']
                  + (float)$form['depreciation'] + (float)$form['advertising']
                  + (float)$form['other_deductions'];

$taxableBeforeNol = $totalIncome - $totalDeductions;
$taxableIncome     = $taxableBeforeNol;
$totalPayments     = (float)$form['estimated_payments'] + (float)$form['tax_deposited_7004'] + (float)$form['withholding'];

$pdf = new Fpdi();
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Ikusa LLC');
$pdf->setTitle('IRS Form 1120 (Pro-Forma) - ' . $taxYear . ' v' . $filing['version']);
$pdf->setSubject('irs');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$templatePath = __DIR__ . '/1120_compat.pdf';
$pageCount = $pdf->setSourceFile($templatePath);

$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(false, 0);

for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $pdf->AddPage('P', 'LETTER');
    $templateId = $pdf->importPage($pageNo);
    $size = $pdf->getTemplateSize($templateId);
    $pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

    $pdf->SetFont('Helvetica', '', 9);

    if ($pageNo === 1) {
        $pdf->SetXY(100, 17.5); $pdf->Write(0, 'January');
        $pdf->SetXY(143, 17.5); $pdf->Write(0, 'December');
        $pdf->SetXY(165, 17.5); $pdf->Write(0, substr($taxYear, -2));

        $xName = 56.0; $xEIN = 181.0; $xRight = 197.0;
        $yName = 28.6; $yAddress = 38.6; $yCity = 46.6;

        $pdf->SetXY($xName, $yName);    $pdf->Write(0, $form['corp_name']);
        $pdf->SetXY($xName, $yAddress); $pdf->Write(0, $form['corp_address']);
        $pdf->SetXY($xName, $yCity);    $pdf->Write(0, $form['corp_city']);
        $pdf->SetXY(81.0,   $yCity);    $pdf->Write(0, $form['corp_state']);
        $pdf->SetXY(112.0,  $yCity);    $pdf->Write(0, $form['corp_country']);
        $pdf->SetXY(141.0,  $yCity);    $pdf->Write(0, $form['corp_zip']);

        $pdf->SetXY($xEIN, $yName);    $pdf->Write(0, $form['ein']);
        $pdf->SetXY($xEIN, $yAddress); $pdf->Write(0, date('m/d/Y', strtotime($form['date_incorporated'])));
        $pdf->SetXY($xEIN, $yCity);    $pdf->Write(0, f($totalAssetsEnd));

        $y1a=56.2; $y1c=64.7; $y2=68.9; $y3=73.2; $y4=77.4; $y5=81.6; $y6=85.9; $y7=90.1; $y8=94.3; $y10=102.8; $y11=107.0;
        if ($form['gross_receipts'])     writeRight($pdf, 163.0, $y1a, f($form['gross_receipts']));
        if ($balance1c)                  writeRight($pdf, $xRight, $y1c, f($balance1c));
        if ($form['cost_of_goods_sold']) writeRight($pdf, $xRight, $y2, f($form['cost_of_goods_sold']));
        if ($grossProfit)                writeRight($pdf, $xRight, $y3, f($grossProfit));
        if ($form['dividends'])          writeRight($pdf, $xRight, $y4, f($form['dividends']));
        if ($form['interest_income'])    writeRight($pdf, $xRight, $y5, f($form['interest_income']));
        if ($form['gross_rents'])        writeRight($pdf, $xRight, $y6, f($form['gross_rents']));
        if ($form['gross_royalties'])    writeRight($pdf, $xRight, $y7, f($form['gross_royalties']));
        if ($form['capital_gain'])       writeRight($pdf, $xRight, $y8, f($form['capital_gain']));
        if ($form['other_income'])       writeRight($pdf, $xRight, $y10, f($form['other_income']));
        if ($totalIncome)                writeRight($pdf, $xRight, $y11, f($totalIncome));

        $y12=111.3; $y13=115.5; $y14=119.7; $y15=124.0; $y16=128.2; $y17=132.4; $y18=136.7; $y19=140.9; $y20=145.1;
        $y22=153.6; $y26=170.5; $y27=174.7; $y28=179.0; $y30=195.9; $y31=200.2; $y33=208.6; $y35=217.1; $y36=221.3; $y37b=225.5;

        if ($form['compensation_officers']) writeRight($pdf, $xRight, $y12, f($form['compensation_officers']));
        if ($form['salaries_wages'])        writeRight($pdf, $xRight, $y13, f($form['salaries_wages']));
        if ($form['repairs_maintenance'])   writeRight($pdf, $xRight, $y14, f($form['repairs_maintenance']));
        if ($form['bad_debts'])             writeRight($pdf, $xRight, $y15, f($form['bad_debts']));
        if ($form['rents'])                 writeRight($pdf, $xRight, $y16, f($form['rents']));
        if ($form['taxes_licenses'])        writeRight($pdf, $xRight, $y17, f($form['taxes_licenses']));
        if ($form['interest_deduction'])    writeRight($pdf, $xRight, $y18, f($form['interest_deduction']));
        if ($form['charitable'])            writeRight($pdf, $xRight, $y19, f($form['charitable']));
        if ($form['depreciation'])          writeRight($pdf, $xRight, $y20, f($form['depreciation']));
        if ($form['advertising'])           writeRight($pdf, $xRight, $y22, f($form['advertising']));
        if ($form['other_deductions'])      writeRight($pdf, $xRight, $y26, f($form['other_deductions']));
        if ($totalDeductions)               writeRight($pdf, $xRight, $y27, f($totalDeductions));
        if ($taxableBeforeNol)              writeRight($pdf, $xRight, $y28, f($taxableBeforeNol));
        if ($taxableIncome)                 writeRight($pdf, $xRight, $y30, f($taxableIncome));
        if ($totalPayments)                 writeRight($pdf, $xRight, $y33, f($totalPayments));

        $pdf->SetXY(95.0, 244.6);  $pdf->Write(0, date('m-d-Y', strtotime($form['signature_date'])));
        $pdf->SetXY(115.0, 244.6); $pdf->Write(0, $form['signer_title']);
        $pdf->SetXY(35.0, 256.6);  $pdf->Write(0, $form['signer_name']);

        // Firma escaneada sobre la línea "Signature of officer"
        $firmaPath = dirname(__DIR__, 7) . '/app/src/Domains/Admin/Irs/views/1120/firma_nicolas_granda.png';
        if (file_exists($firmaPath)) {
            $pdf->Image($firmaPath, 22, 240, 35, 0, 'PNG');
        }
    }

    if ($pageNo === 4) {
        if (($form['accounting_method'] ?? 'cash') === 'cash') {
            $pdf->SetFont('dejavusans', '', 12);
            $pdf->SetXY(63.0, 20.0); $pdf->Write(0, '✓');
            $pdf->SetFont('Helvetica', '', 9);
        }
        $pdf->SetXY(65.0, 30.0); $pdf->Write(0, $form['activity_code']);
        $pdf->SetXY(45.0, 33.5); $pdf->Write(0, $form['activity']);

        $pdf->SetFont('dejavusans', '', 12);
        $pdf->SetXY(197.5, 42.5); $pdf->Write(0, '✓');
        $pdf->SetXY(190.0, 77.5); $pdf->Write(0, '✓');
        $pdf->SetXY(197.5, 192.5); $pdf->Write(0, '✓');
        $pdf->SetXY(190.0, 207.5); $pdf->Write(0, '✓');
        $pdf->SetFont('Helvetica', '', 9);

        $pdf->SetXY(56.0, 217.5);  $pdf->Write(0, number_format((float)$form['shareholder_pct'], 0) . '%');
        $pdf->SetXY(112.0, 217.5); $pdf->Write(0, 'Spain');
        $pdf->SetXY(178.0, 227.5); $pdf->Write(0, '1');
        $pdf->SetXY(178.0, 243.0); $pdf->Write(0, '1');
    }

    if ($pageNo === 5) {
        $pdf->SetFont('dejavusans', '', 12);
        $xNo = 197.5;
        $pdf->SetXY(190.0, 25.0); $pdf->Write(0, '✓');
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY(165.0, 35.0); $pdf->Write(0, f($form['cash_distributions']));
        $pdf->SetFont('dejavusans', '', 12);
        foreach ([37,45,50,57.5,67,77,82,87.5,97.5,105,118,122,142,162,175,180.0,192.5,202.5,217.5,230,233,237.5,252.5] as $y) {
            $pdf->SetXY($xNo, $y); $pdf->Write(0, '✓');
        }
    }

    if ($pageNo === 6) {
        $pdf->SetFont('Helvetica', '', 9);
        $xBR = 142.5; $xDR = 200.0;
        $yL1=26.5; $yL15=102.6; $yL22b=140.5; $yL25=153; $yL28=165;

        writeRight($pdf, $xBR, $yL1, f($form['cash_beginning']));
        writeRight($pdf, $xDR, $yL1, f($form['cash_end']));
        writeRight($pdf, $xBR, $yL15, f($totalAssetsBeginning));
        writeRight($pdf, $xDR, $yL15, f($totalAssetsEnd));
        writeRight($pdf, $xBR, $yL22b, f($form['common_stock_beginning']));
        writeRight($pdf, $xDR, $yL22b, f($form['common_stock_end']));

        $reBeginFmt = $form['retained_earnings_begin'] < 0 ? '(' . f($form['retained_earnings_begin']) . ')' : f($form['retained_earnings_begin']);
        $reEndFmt   = $form['retained_earnings'] < 0       ? '(' . f($form['retained_earnings']) . ')'       : f($form['retained_earnings']);
        writeRight($pdf, $xBR, $yL25, $reBeginFmt);
        writeRight($pdf, $xDR, $yL25, $reEndFmt);

        writeRight($pdf, $xBR, $yL28, f($totalAssetsBeginning));
        writeRight($pdf, $xDR, $yL28, f($totalAssetsEnd));

        $xBR = 105;
        writeRight($pdf, $xBR, 179.0, f($taxableIncome));
        writeRight($pdf, $xBR, 229.6, f($taxableIncome));
        writeRight($pdf, $xDR, 229.6, f($taxableIncome));

        $m2BeginFmt = $form['retained_earnings_begin'] < 0 ? '(' . f($form['retained_earnings_begin']) . ')' : f($form['retained_earnings_begin']);
        writeRight($pdf, $xBR, 237.0, $m2BeginFmt);
        writeRight($pdf, $xBR, 242.5, f($taxableIncome));

        $m2l4 = (float)$form['retained_earnings_begin'] + $taxableIncome;
        writeRight($pdf, $xBR, 259.3, $m2l4 < 0 ? '(' . f($m2l4) . ')' : f($m2l4));
        writeRight($pdf, $xDR, 259.3, f($m2l4));
    }
}

$mode = $mode ?? ($_GET['mode'] ?? 'view');
if ($mode === 'download') {
    $pdf->Output('Form1120_' . $taxYear . '_v' . $filing['version'] . '.pdf', 'D');
} elseif ($mode === 'save' && isset($savePath)) {
    $pdf->Output($savePath, 'F');
} else {
    $pdf->Output('Form1120_' . $taxYear . '_v' . $filing['version'] . '.pdf', 'I');
}
