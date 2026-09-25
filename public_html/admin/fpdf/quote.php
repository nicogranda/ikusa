<?php
require('fpdf.php');

// Conexión a la base de datos
include '../../../app/config/connection.php';

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$quote_id = $_GET['id'];

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Logo
$logoPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/logo.png';
$pdf->Image($logoPath, 120, 5, 30);

// Texto "Quote"
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 5, utf8_decode('Quote'), 0, 1, 'L');

// Formatea el ID con ceros a la izquierda
$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Times', 'B', 16);

$formatted_quote_id = str_pad($quote_id, 9, '0', STR_PAD_LEFT);
$pdf->Cell(30, 5, utf8_decode($formatted_quote_id), 0, 1, 'L');

$pdf->SetTextColor(0, 0, 0);

// Añadir información del cliente
$quotes = $mysqli->query("SELECT * FROM quotes WHERE id = '$quote_id'");

if ($quotes && $row = $quotes->fetch_assoc()) {

    $client_id = $row['business_id'];
    $created_at = $row['created_at'];

    $clients = $mysqli->query("SELECT * FROM clients WHERE id = '$client_id'");

    if ($clients && $client = $clients->fetch_assoc()) {

        $pdf->SetFont('Arial', '', 10);

        // Fecha
        $formatted_date = date("m-d-Y", strtotime($created_at));
        $pdf->Cell(30, 5, utf8_decode($formatted_date), 0, 1, 'L');

        // Datos IKUSA
        $x = 160;
        $y = 5;

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 4, "Ikusa LLC", 0, 1);

        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, "8735 Dunwoody Place, Ste R", 0, 1);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, "Atlanta, GA 30350", 0, 1);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, "United States", 0, 1);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, "https://ikusa.net", 0, 1);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, "DUNS: 100861837", 0, 1);

        // Cliente
        $pdf->SetFont('Arial', '', 10);
        $pdf->Ln(10);

        $pdf->Cell(20, 5, utf8_decode("Client: "), 0, 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode($client['name']), 0, 1);

        // Dirección
        $pdf->SetX(30);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 5, utf8_decode($client['address']), 0, 1);

        $pdf->SetX(30);
        $pdf->Cell(
            0,
            5,
            utf8_decode(
                $client['city'] . ', ' .
                $client['state'] . ', ' .
                $client['zip_code']
            ),
            0,
            1
        );

        $pdf->SetX(30);
        $pdf->Cell(0, 5, utf8_decode($client['country']), 0, 1);

    } else {

        $pdf->Cell(
            0,
            5,
            utf8_decode("Client information not found."),
            0,
            1
        );
    }
}

// Tabla de productos
$pdf->Ln(10);

$pdf->SetFillColor(255, 69, 0);
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell(50, 10, utf8_decode('Goods/Service'), '', 0, 'C', true);
$pdf->Cell(20, 10, 'Quantity', '', 0, 'C', true);
$pdf->Cell(35, 10, utf8_decode('Unit Value'), '', 0, 'C', true);
$pdf->Cell(15, 10, 'Unit', '', 0, 'C', true);
$pdf->Cell(25, 10, utf8_decode('Discount (%)'), '', 0, 'C', true);
$pdf->Cell(20, 10, 'Vat Rate', '', 0, 'C', true);
$pdf->Cell(30, 10, utf8_decode('Total'), '', 1, 'C', true);

$pdf->SetTextColor(0, 0, 0);

$total = 0;
$subtotal = 0;
$vat = 0;

// IMPORTANTE: orden por position
$quotes_details = $mysqli->query("
    SELECT *
    FROM quotes_details
    WHERE quote_id = '$quote_id'
    ORDER BY position ASC, id ASC
");

while ($row = $quotes_details->fetch_assoc()) {

    $product_id = $row['product_id'];
    $note = $row['note'];
    $unit_value = $row['unit_value'];
    $quantity = $row['quantity'];
    $discount = $row['discount'];
    $vat_rate = $row['vat_rate'];

    // Cálculos
    $lineSubtotal =
        $quantity *
        $unit_value *
        (1 - $discount / 100);

    $vatItem =
        $lineSubtotal *
        ($vat_rate / 100);

    $balance =
        $lineSubtotal +
        $vatItem;

    $subtotal += $lineSubtotal;
    $vat += $vatItem;

    // Producto
    $products = $mysqli->query("
        SELECT *
        FROM products
        WHERE id = '$product_id'
    ");

    while ($product = $products->fetch_assoc()) {

        // Nombre
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(
            50,
            5,
            utf8_decode($product["name"]),
            '',
            0
        );

        // Columnas
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(20, 5, $quantity, '', 0, 'R');

        $pdf->Cell(
            35,
            5,
            number_format($unit_value, 2),
            '',
            0,
            'R'
        );

        $pdf->Cell(
            15,
            5,
            utf8_decode($product["unit"]),
            '',
            0,
            'R'
        );

        $pdf->Cell(
            25,
            5,
            number_format($discount, 2),
            '',
            0,
            'R'
        );

        $pdf->Cell(
            20,
            5,
            number_format($vat_rate, 2),
            '',
            0,
            'R'
        );

        $pdf->Cell(
            30,
            5,
            number_format($balance, 2),
            '',
            1,
            'R'
        );

        // Nota debajo del producto
        $pdf->SetX(10);

        $bulletSize = 4;
        $space = 2;

        $noteLines = explode("\n", $note);

        foreach ($noteLines as $line) {

            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $x0 = $pdf->GetX();
            $y0 = $pdf->GetY();

            // Cuadrado naranja
            $pdf->SetFillColor(255, 140, 0);

            $pdf->Rect(
                $x0,
                $y0 + 1,
                $bulletSize,
                $bulletSize,
                'F'
            );

            // Texto
            $pdf->SetXY(
                $x0 + $bulletSize + $space,
                $y0
            );

            $pdf->MultiCell(
                180 - $bulletSize - $space,
                5,
                utf8_decode($line),
                0,
                'L'
            );
        }

        // Más separación antes de la línea
        $pdf->Ln(2);

        // Línea separadora
        $pdf->Cell(
            195,
            0,
            '',
            'T',
            1
        );

        // Más separación después de la línea
        $pdf->Ln(3);
    }
}

// Totales
$total = $subtotal + $vat;

$pdf->SetFont('Arial', '', 10);

$pdf->Cell(
    165,
    10,
    'Sub-total',
    '',
    0,
    'L'
);

$pdf->Cell(
    30,
    10,
    number_format($subtotal, 2),
    '',
    1,
    'R'
);

$pdf->Cell(
    165,
    10,
    utf8_decode('VAT'),
    '',
    0,
    'L'
);

$pdf->Cell(
    30,
    10,
    number_format($vat, 2),
    '',
    1,
    'R'
);

$pdf->Cell(
    165,
    10,
    'Total',
    'B',
    0,
    'L'
);

$pdf->Cell(
    30,
    10,
    number_format($total, 2),
    'B',
    1,
    'R'
);

// Nota fiscal
$pdf->SetFont('Arial', '', 8);

$pdf->MultiCell(
    0,
    5,
    utf8_decode(
        'VAT not charged. Reverse charge applies under Article 196 of the EU VAT Directive. Customer is responsible for VAT in Spain.'
    ),
    0,
    'L'
);

$pdf->MultiCell(
    0,
    5,
    utf8_decode(
        'IVA no incluido. Operación sujeta a inversión del sujeto pasivo (Art. 196 Directiva IVA UE). El cliente deberá autoliquidar el IVA en España.'
    ),
    0,
    'L'
);


/*
|--------------------------------------------------------------------------
| DATOS BANCARIOS
|--------------------------------------------------------------------------
| Ocultos temporalmente.
| Para volver a mostrarlos, elimina este comentario de bloque.
|--------------------------------------------------------------------------
*/

/*

$y = 225;
$lineHeight = 8;
$xImg = 110;
$xText = 120;

// Título
$pdf->SetFont('Arial', '', 8);

$pdf->SetXY($xImg, $y);

$pdf->Cell(
    0,
    6,
    utf8_decode('Payment Method / Métodos de pago'),
    0,
    1,
    'L'
);

$y += 5;

// Zelle
$pdf->Image(
    $_SERVER['DOCUMENT_ROOT'] . '/assets/img/banks/zelle.png',
    $xImg,
    $y,
    8
);

$pdf->SetXY($xText, $y);

$pdf->Cell(
    0,
    8,
    utf8_decode('E-mail: ikusa.ads@gmail.com'),
    0,
    1,
    'L'
);

$y += $lineHeight;

// Bank of America
$pdf->Image(
    $_SERVER['DOCUMENT_ROOT'] . '/assets/img/banks/bofa.png',
    $xImg,
    $y,
    8
);

$pdf->SetXY($xText, $y);

$pdf->Cell(
    0,
    8,
    utf8_decode(
        'Account: 334070489489, Routing: 061000052, SWIFT: BOFAUS6S'
    ),
    0,
    1,
    'L'
);

$y += $lineHeight;

// Wise
$pdf->Image(
    $_SERVER['DOCUMENT_ROOT'] . '/assets/img/banks/wise.png',
    $xImg,
    $y,
    8
);

$pdf->SetXY($xText, $y);

$pdf->Cell(
    0,
    8,
    utf8_decode(
        'IBAN: BE82 9678 2700 3168'
    ),
    0,
    1,
    'L'
);

$y += 15;

*/


// Íconos RRSS
$icons = [
    $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rrss/instagram.png',
    $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rrss/facebook.png',
    $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rrss/linkedIn.png'
];

$y = 282;
$iconSize = 5;

$totalWidth =
    count($icons) * $iconSize +
    (count($icons) - 1) * 5;

$x = (210 - $totalWidth) / 2;

foreach ($icons as $icon) {

    $pdf->Image(
        $icon,
        $x,
        $y,
        $iconSize
    );

    $x += $iconSize + 5;
}

// Salida
$pdf->Output(
    'I',
    'quote_' . $quote_id . '.pdf'
);
?>