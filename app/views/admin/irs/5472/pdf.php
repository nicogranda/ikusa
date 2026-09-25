<?php
// app/views/admin/irs/5472/pdf.php
//
// FORM 5472
// Foreign-Owned U.S. Disregarded Entity
//
// Variables disponibles:
// $filing
// $form

require_once '/home/ot2ryobi838h/vendor/autoload.php';

use setasign\Fpdi\Tcpdf\Fpdi;


// ============================================================
// HELPERS
// ============================================================

function fmt($val): string
{
    $val = (float)($val ?? 0);

    return $val != 0
        ? number_format($val, 2, '.', ',')
        : '';
}


// ============================================================
// VARIABLES
// ============================================================

$taxYear     = (int)$filing['tax_year'];
$isCorrected = (bool)($filing['is_corrected'] ?? false);

$cityStateZip = trim(
    ($form['corp_city'] ?? '') .
    ', ' .
    ($form['corp_state'] ?? '') .
    ' ' .
    ($form['corp_zip'] ?? '')
);

$referenceId = trim(
    $form['shareholder_reference_id'] ?? ''
);

$ftin = trim(
    $form['shareholder_ftin'] ?? ''
);

$distributionAmount = (float)(
    $form['distribution_amount'] ?? 0
);


// ============================================================
// PDF
// ============================================================

$pdf = new Fpdi();

$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Ikusa LLC');

$pdf->setTitle(
    'IRS Form 5472 - ' .
    $taxYear .
    ' v' .
    ($filing['version'] ?? 1)
);

$pdf->setSubject('IRS Form 5472');

$pdf->setKeywords(
    'TCPDF, PDF, IRS, Form 5472'
);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(false, 0);


// ============================================================
// PLANTILLA
// ============================================================

$templatePath =
    '/home/ot2ryobi838h/app/views/admin/irs/5472/5472.pdf';

if (!file_exists($templatePath)) {
    die('No se encontró la plantilla 5472.pdf');
}

$pageCount = $pdf->setSourceFile($templatePath);


// ============================================================
// IMPORTAR FORMULARIO OFICIAL
// ============================================================

for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {

    $pdf->AddPage('P', 'LETTER');

    $templateId = $pdf->importPage($pageNo);

    $size = $pdf->getTemplateSize($templateId);

    $pdf->useTemplate(
        $templateId,
        0,
        0,
        $size['width'],
        $size['height']
    );


    // ========================================================
    // PAGE 1
    // ========================================================

    if ($pageNo === 1) {

        $pdf->SetFont('Helvetica', '', 9);


        // ----------------------------------------------------
        // CORRECTED
        // ----------------------------------------------------

        if ($isCorrected) {

            $pdf->SetFont('Helvetica', 'B', 9);

            $pdf->SetXY(180, 10);
            $pdf->Write(0, 'CORRECTED');

            $pdf->SetFont('Helvetica', '', 9);
        }


        // ----------------------------------------------------
        // TAX YEAR
        // ----------------------------------------------------

        $pdf->SetXY(100, 29);
        $pdf->Write(0, 'January');

        $pdf->SetXY(120, 29);
        $pdf->Write(0, $taxYear);

        $pdf->SetXY(143, 29);
        $pdf->Write(0, 'December');

        $pdf->SetXY(163, 29);
        $pdf->Write(0, $taxYear);


        // ----------------------------------------------------
        // PART I
        // ----------------------------------------------------

        $pdf->SetXY(15, 45);
        $pdf->Write(
            0,
            $form['corp_name'] ?? ''
        );

        $pdf->SetXY(170, 45);
        $pdf->Write(
            0,
            $form['ein'] ?? ''
        );

        $pdf->SetXY(15, 54);
        $pdf->Write(
            0,
            $form['corp_address'] ?? ''
        );

        $pdf->SetXY(15, 63);
        $pdf->Write(
            0,
            $cityStateZip
        );


        // Total assets

        $pdf->SetXY(168, 62);

        $pdf->Write(
            0,
            fmt($form['total_assets'] ?? 0)
        );


        // Principal business activity

        $pdf->SetXY(55, 67.5);

        $pdf->Write(
            0,
            $form['business_activity'] ?? ''
        );

        $pdf->SetXY(180, 67.5);

        $pdf->Write(
            0,
            $form['activity_code'] ?? ''
        );


        // ----------------------------------------------------
        // 1f / 1g / 1h
        //
        // Reportable Part V distribution
        // ----------------------------------------------------

        $grossPayments = fmt(
            $distributionAmount
        );

        $pdf->SetXY(20, 80);
        $pdf->Write(
            0,
            $grossPayments
        );

        $pdf->SetXY(100, 80);
        $pdf->Write(
            0,
            '1'
        );

        $pdf->SetXY(155, 80);
        $pdf->Write(
            0,
            $grossPayments
        );


        // ----------------------------------------------------
        // 1l COUNTRY OF INCORPORATION
        // ----------------------------------------------------

        $pdf->SetXY(168, 90);

        $pdf->Write(
            0,
            $form['incorporation_country']
                ?? 'United States'
        );


        // ----------------------------------------------------
        // 1m DATE OF INCORPORATION
        // ----------------------------------------------------

        if (!empty(
            $form['incorporation_date']
        )) {

            $pdf->SetXY(15, 104);

            $pdf->Write(
                0,
                date(
                    'm/d/Y',
                    strtotime(
                        $form['incorporation_date']
                    )
                )
            );
        }


        // ----------------------------------------------------
        // 1n
        //
        // Country under whose laws the REPORTING CORPORATION
        // files an income tax return as resident.
        //
        // IMPORTANT:
        // Spain is the OWNER'S tax residence, not automatically
        // the LLC's residence.
        // ----------------------------------------------------

        $pdf->SetXY(82, 105);

        $pdf->Write(
            0,
            'United States'
        );


        // ----------------------------------------------------
        // 1o
        //
        // Principal countries where BUSINESS IS CONDUCTED.
        //
        // This remains data-driven when the field exists.
        // ----------------------------------------------------

        $principalCountries = trim(
            $form['principal_countries_business']
                ?? ''
        );

        if ($principalCountries === '') {
            $principalCountries =
                'United States, Spain';
        }

        $pdf->SetXY(150, 105);

        $pdf->Write(
            0,
            $principalCountries
        );


        // ----------------------------------------------------
        // QUESTIONS 2 AND 3
        // ----------------------------------------------------

        $pdf->SetFont(
            'dejavusans',
            '',
            14
        );

        if (!empty(
            $form['foreign_owned_50pct']
        )) {

            $pdf->SetXY(197, 113);
            $pdf->Write(0, '✓');
        }

        if (!empty(
            $form['is_disregarded_entity']
        )) {

            $pdf->SetXY(197, 121);
            $pdf->Write(0, '✓');
        }


        // ----------------------------------------------------
        // PART II
        // 25% FOREIGN SHAREHOLDER
        // ----------------------------------------------------

        $pdf->SetFont(
            'Helvetica',
            '',
            8
        );

        $pdf->SetXY(15, 143);

        $pdf->Write(
            0,
            $form[
                'shareholder_full_address_line'
            ] ?? ''
        );

        $pdf->SetFont(
            'Helvetica',
            '',
            9
        );


        // ----------------------------------------------------
        // 4b(1)
        // U.S. identifying number
        //
        // VACÍO.
        // No SSN / ITIN.
        // ----------------------------------------------------


        // ----------------------------------------------------
        // 4b(2)
        // REFERENCE ID
        // ----------------------------------------------------

        $pdf->SetXY(70, 155);

        $pdf->Write(
            0,
            $referenceId
        );


        // ----------------------------------------------------
        // 4b(3)
        // FTIN
        // ----------------------------------------------------

        $pdf->SetXY(148, 155);

        $pdf->Write(
            0,
            $ftin
        );


        // ----------------------------------------------------
        // 4c
        // Principal country where shareholder conducts business
        // ----------------------------------------------------

        $pdf->SetXY(15, 167);

        $pdf->Write(
            0,
            $form['shareholder_country']
                ?? ''
        );


        // ----------------------------------------------------
        // 4d
        // CITIZENSHIP
        // ----------------------------------------------------

        $pdf->SetXY(70, 167);

        $pdf->Write(
            0,
            $form[
                'shareholder_citizenship_country'
            ]
            ?? $form['shareholder_country']
            ?? ''
        );


        // ----------------------------------------------------
        // 4e
        // TAX RESIDENCE
        // ----------------------------------------------------

        $pdf->SetXY(148, 167);

        $pdf->Write(
            0,
            $form[
                'shareholder_tax_country'
            ] ?? ''
        );
    }


    // ========================================================
    // PAGE 2
    // ========================================================

    if ($pageNo === 2) {

        $pdf->SetFont(
            'Helvetica',
            '',
            9
        );


        // ----------------------------------------------------
        // PART III
        // FOREIGN PERSON
        // ----------------------------------------------------

        $pdf->SetFont(
            'Helvetica',
            'B',
            10
        );

        $pdf->SetXY(
            101.5,
            21.2
        );

        $pdf->Write(
            0,
            'X'
        );


        $pdf->SetFont(
            'Helvetica',
            '',
            9
        );


        // 8a

        $pdf->SetXY(15, 28);

        $pdf->Write(
            0,
            $form['shareholder_name']
                ?? ''
        );


        // ----------------------------------------------------
        // 8b(1)
        // U.S. identifying number
        //
        // VACÍO.
        // ----------------------------------------------------


        // ----------------------------------------------------
        // 8b(2)
        // REFERENCE ID
        // ----------------------------------------------------

        $pdf->SetXY(70, 37);

        $pdf->Write(
            0,
            $referenceId
        );


        // ----------------------------------------------------
        // 8b(3)
        // FTIN
        // ----------------------------------------------------

        $pdf->SetXY(148, 37);

        $pdf->Write(
            0,
            $ftin
        );


        // ----------------------------------------------------
        // 8c
        // ----------------------------------------------------

        $pdf->SetXY(55, 42.5);

        $pdf->Write(
            0,
            $form[
                'related_party_activity'
            ] ?? ''
        );


        // ----------------------------------------------------
        // 8d
        // ----------------------------------------------------

        $pdf->SetXY(180, 42.5);

        $pdf->Write(
            0,
            $form['activity_code']
                ?? ''
        );


        // ----------------------------------------------------
        // 8e RELATIONSHIP
        // ----------------------------------------------------

        $pdf->SetFont(
            'Helvetica',
            'B',
            10
        );


        // Related to reporting corporation

        $pdf->SetXY(
            68.0,
            47.0
        );

        $pdf->Write(
            0,
            'X'
        );


        // Related to 25% foreign shareholder

        $pdf->SetXY(
            116.8,
            47.0
        );

        $pdf->Write(
            0,
            'X'
        );


        // 25% foreign shareholder

        $pdf->SetXY(
            167.6,
            47.0
        );

        $pdf->Write(
            0,
            'X'
        );


        $pdf->SetFont(
            'Helvetica',
            '',
            9
        );


        // ----------------------------------------------------
        // 8f
        // ----------------------------------------------------

        $pdf->SetXY(
            15,
            57
        );

        $pdf->Write(
            0,
            $form['shareholder_country']
                ?? ''
        );


        // ----------------------------------------------------
        // 8g
        // ----------------------------------------------------

        $pdf->SetXY(
            115,
            57
        );

        $pdf->Write(
            0,
            $form[
                'shareholder_tax_country'
            ] ?? ''
        );


        // ----------------------------------------------------
        // PART V
        // ----------------------------------------------------

        if ($distributionAmount > 0) {

            $pdf->SetFont(
                'Helvetica',
                'B',
                10
            );

            $pdf->SetXY(
                173,
                215
            );

            $pdf->Write(
                0,
                'X'
            );
        }
    }


    // ========================================================
    // PAGE 3
    // PART VII — ADDITIONAL INFORMATION
    // ========================================================

    if ($pageNo === 3) {

        /*
         * Para el caso actual:
         *
         * 37  Import goods from foreign related party?       NO
         * 38a Solo aplica si 37 = YES                       N/A
         * 38c Solo aplica si 37 y 38a = YES                 N/A
         * 39  Foreign parent participant in CSA?            NO
         * 40a Section 267A interest/royalty?                 NO
         * 41a FDII deduction re foreign related party?       NO
         * 42a Loan using safe-haven interest range?          NO
         * 42b Loan outside safe-haven interest range?        NO
         * 43a Covered debt instrument / related debt?        NO
         *
         * No inventamos respuestas a 38a/38c porque son
         * preguntas condicionales que no aplican cuando 37=NO.
         */

        $pdf->SetFont(
            'Helvetica',
            'B',
            10
        );


        // ----------------------------------------------------
        // IMPORTANT:
        //
        // Estas coordenadas corresponden a la plantilla
        // 5472 Rev. 12-2023 que estás usando.
        //
        // Si visualmente alguna X queda unos milímetros fuera,
        // solo se ajustan estas coordenadas.
        // ----------------------------------------------------

        // 37 — NO
        $pdf->SetXY(191.0,20.5); $pdf->Write(0,'X');
        
        // 39 — NO
        $pdf->SetXY(191.0,42.5); $pdf->Write(0,'X');
        
        // 40a — NO
       $pdf->SetXY(191.0,55.0); $pdf->Write(0,'X');
   
        // 41a — NO
        $pdf->SetXY(191.0,67.5); $pdf->Write(0,'X');     
      
        // 42a — NO
        $pdf->SetXY(191.0,104.0); $pdf->Write(0,'X');
   
        // 42b — NO
         $pdf->SetXY(191.0,115.0); $pdf->Write(0,'X');
        // $pdf->SetXY(191.0,130.0); $pdf->Write(0,'X');
    }
}


// ============================================================
// PART V STATEMENT
// ============================================================

if ($distributionAmount > 0) {

    $pdf->AddPage(
        'P',
        'LETTER'
    );


    // --------------------------------------------------------
    // TITLE
    // --------------------------------------------------------

    $pdf->SetFont(
        'Helvetica',
        'B',
        11
    );

    $pdf->SetXY(
        15,
        20
    );

    $pdf->Write(
        0,
        'Form 5472 — Part V Statement'
    );


    // --------------------------------------------------------
    // HEADER
    // --------------------------------------------------------

    $pdf->SetFont(
        'Helvetica',
        '',
        9
    );

    $pdf->SetXY(
        15,
        30
    );

    $pdf->Write(
        0,
        'Reporting Corporation: ' .
        ($form['corp_name'] ?? '')
    );


    $pdf->SetXY(
        15,
        36
    );

    $pdf->Write(
        0,
        'EIN: ' .
        ($form['ein'] ?? '')
    );


    $pdf->SetXY(
        15,
        42
    );

    $pdf->Write(
        0,
        'Tax Year: January 1, ' .
        $taxYear .
        ' – December 31, ' .
        $taxYear
    );


    $pdf->SetXY(
        15,
        48
    );

    $pdf->Write(
        0,
        'Related Foreign Party / Sole Foreign Owner: ' .
        ($form['shareholder_name'] ?? '')
    );


    $pdf->SetXY(
        15,
        54
    );

    $pdf->Write(
        0,
        'FTIN: ' .
        $ftin
    );


    $pdf->SetXY(
        15,
        60
    );

    $pdf->Write(
        0,
        'Reference ID: ' .
        $referenceId
    );


    // --------------------------------------------------------
    // DESCRIPTION
    // --------------------------------------------------------

    $pdf->SetFont(
        'Helvetica',
        'B',
        9
    );

    $pdf->SetXY(
        15,
        72
    );

    $pdf->Write(
        0,
        'Reportable Transaction — Part V'
    );


    $pdf->SetFont(
        'Helvetica',
        '',
        9
    );


    $text =
        'During tax year ' .
        $taxYear .
        ', ' .
        ($form['corp_name'] ?? '') .
        ', a foreign-owned U.S. disregarded entity treated as a corporation solely for purposes of section 6038A, ' .
        'made cash distributions totaling $' .
        fmt($distributionAmount) .
        ' to its sole foreign owner, ' .
        ($form['shareholder_name'] ?? '') .
        '. These distributions constitute reportable transactions for purposes of Part V.' .

        "\n\n" .

        'Total Part V distribution to the related foreign party: $' .
        fmt($distributionAmount) .
        '.' .

        "\n\n" .

        'Reference ID clarification: The same foreign owner was identified on the 2024 Form 5472 using the self-assigned Reference ID 27-000-001. ' .
        'For this corrected 2025 filing, the Reference ID is 27000001, consisting of the same digits with the hyphens removed in order to comply with the current Form 5472 requirement that Reference ID numbers be alphanumeric and contain no special characters or spaces.';


    $pdf->SetXY(
        15,
        82
    );

    $pdf->MultiCell(
        180,
        6,
        $text,
        0,
        'L'
    );
}


// ============================================================
// OUTPUT
// ============================================================

$mode =
    $mode
    ?? ($_GET['mode'] ?? 'view');

$version =
    $filing['version']
    ?? 1;

$filename =
    'Form5472_' .
    $taxYear .
    '_v' .
    $version .
    '.pdf';


if ($mode === 'download') {

    $pdf->Output(
        $filename,
        'D'
    );

} elseif (
    $mode === 'save'
    &&
    isset($savePath)
) {

    $pdf->Output(
        $savePath,
        'F'
    );

} else {

    $pdf->Output(
        $filename,
        'I'
    );
}

exit;