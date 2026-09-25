<?php
// app/views/admin/irs/1120/proforma.php
//
// FORM 1120 PRO FORMA
// FOREIGN-OWNED U.S. DISREGARDED ENTITY
//
// IMPORTANTE:
// Este archivo NO sustituye ni modifica 1120/pdf.php.
// Genera SOLAMENTE la página 1 del Form 1120.

require_once '/home/ot2ryobi838h/vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;

$taxYear = (int)$filing['tax_year'];

$pdf = new Fpdi();

$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Ikusa LLC');
$pdf->setTitle(
    'IRS Form 1120 Pro Forma - Foreign-owned U.S. DE - ' . $taxYear
);
$pdf->setSubject('Form 1120 Pro Forma');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(false, 0);


// ============================================================
// PLANTILLA OFICIAL FORM 1120
// ============================================================

$templatePath =
    '/home/ot2ryobi838h/app/views/admin/irs/1120/1120_compat.pdf';

if (!file_exists($templatePath)) {
    die('No se encontró 1120_compat.pdf');
}

$pdf->setSourceFile($templatePath);


// ============================================================
// IMPORTAR SOLAMENTE PAGINA 1
// ============================================================

$templateId = $pdf->importPage(1);

$size = $pdf->getTemplateSize($templateId);

$pdf->AddPage('P', 'LETTER');

$pdf->useTemplate(
    $templateId,
    0,
    0,
    $size['width'],
    $size['height']
);

$pdf->SetTextColor(0, 0, 0);


// ============================================================
// FOREIGN-OWNED U.S. DE
// ============================================================

$pdf->SetFont('Helvetica', 'B', 9);

$pdf->SetXY(63, 6.5);

$pdf->Cell(
    90,
    5,
    'FOREIGN-OWNED U.S. DE',
    0,
    0,
    'C'
);


// ============================================================
// TAX YEAR
// ============================================================

$pdf->SetFont('Helvetica', '', 9);

// Mismas coordenadas verificadas en tu generador actual.

$pdf->SetXY(100, 17.5);
$pdf->Write(0, 'January');

$pdf->SetXY(143, 17.5);
$pdf->Write(0, 'December');

$pdf->SetXY(165, 17.5);
$pdf->Write(0, substr((string)$taxYear, -2));


// ============================================================
// NAME + ADDRESS
// ============================================================
//
// Usamos EXACTAMENTE las coordenadas que ya funcionan
// en tu 1120/pdf.php.
//

$xName    = 56.0;
$yName    = 28.6;
$yAddress = 38.6;
$yCity    = 46.6;

$pdf->SetXY($xName, $yName);
$pdf->Write(0, $form['corp_name'] ?? '');

$pdf->SetXY($xName, $yAddress);
$pdf->Write(0, $form['corp_address'] ?? '');

$pdf->SetXY($xName, $yCity);
$pdf->Write(0, $form['corp_city'] ?? '');

$pdf->SetXY(81.0, $yCity);
$pdf->Write(0, $form['corp_state'] ?? '');

$pdf->SetXY(112.0, $yCity);
$pdf->Write(
    0,
    $form['corp_country'] ?? 'United States'
);

$pdf->SetXY(141.0, $yCity);
$pdf->Write(0, $form['corp_zip'] ?? '');


// ============================================================
// ITEM B — EIN
// ============================================================

$pdf->SetXY(181.0, $yName);

$pdf->Write(
    0,
    $form['ein'] ?? ''
);


// ============================================================
// ITEM E
// ============================================================
//
// IMPORTANTE:
//
// E(1) Initial return
// E(2) Final return
// E(3) Name change
// E(4) Address change
//
// NO vamos a marcar ninguna casilla automáticamente.
// No inventamos una condición que no exista.
//
// El Item E queda visible en el formulario oficial.
// Si corresponde alguna condición, después la hacemos
// data-driven desde la base de datos.
//
// ============================================================


// ============================================================
// FIRMA DEL OFFICER
// ============================================================

$firmaPath =
    '/home/ot2ryobi838h/app/views/admin/irs/1120/firma_nicolas_granda.png';

if (file_exists($firmaPath)) {

    $pdf->Image(
        $firmaPath,
        22,
        240,
        35,
        0,
        'PNG'
    );
}


// ============================================================
// FECHA
// ============================================================
//
// Para este paquete: 29 de agosto de 2026.
//

$pdf->SetFont('Helvetica', '', 9);

$pdf->SetXY(95.0, 244.6);
$pdf->Write(0, '08-29-2026');


// ============================================================
// TITLE
// ============================================================

$pdf->SetXY(115.0, 244.6);

$pdf->Write(
    0,
    $form['signer_title'] ?? 'Manager'
);


// ============================================================
// MUY IMPORTANTE:
//
// NO ponemos:
// - signer_name en Paid Preparer
// - ingresos
// - gastos
// - total assets
// - date incorporated
// - Schedule C
// - Schedule J
// - Schedule K
// - Schedule L
// - Schedule M-1
// - Schedule M-2
//
// Es un PRO FORMA para foreign-owned U.S. DE.
// ============================================================


// ============================================================
// OUTPUT
// ============================================================

$filename =
    'IKUSA_1120_PRO_FORMA_' .
    $taxYear .
    '_CORRECTED.pdf';

$pdf->Output(
    $filename,
    'I'
);

exit;