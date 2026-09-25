<?php

namespace App\Services;

require_once __DIR__ . '/../../public_html/admin/fpdf/fpdf.php';

class FpdfService
{
    public function invoice(array $invoice, array $quote, array $client, array $details): void
    {
        $invoiceId = (int) $invoice['id'];
        $createdAt = $invoice['created_at'] ?? date('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | NOMBRE Y METADATOS
        |--------------------------------------------------------------------------
        */

        $clientName = trim($client['name'] ?? 'Client');
        $clientName = preg_replace('/[\/\\\\:*?"<>|]+/', '', $clientName);
        $clientName = preg_replace('/\s+/', ' ', $clientName);

        $fileTitle = 'Invoice ' . $invoiceId . ' ' . $clientName;
        $fileName  = 'Invoice_' . $invoiceId . '_' . str_replace(' ', '_', $clientName) . '.pdf';

        $pdf = new \FPDF('P', 'mm', 'A4');

        $pdf->SetTitle($fileTitle);
        $pdf->SetAuthor('Ikusa LLC');
        $pdf->SetCreator('Ikusa');
        $pdf->SetSubject('Invoice ' . $invoiceId);

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        /*
        |--------------------------------------------------------------------------
        | LOGO
        |--------------------------------------------------------------------------
        */

        $logoPath = $_SERVER['DOCUMENT_ROOT'] . '/assets/img/logo.png';

        if (is_file($logoPath)) {
            $pdf->Image($logoPath, 120, 5, 30);
        }

        /*
        |--------------------------------------------------------------------------
        | FACTURA
        |--------------------------------------------------------------------------
        */

        $pdf->SetFont('Arial', '', 24);
        $pdf->Cell(30, 6, 'Invoice', 0, 1, 'L');

        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetFont('Times', 'B', 16);

        $formattedInvoiceId = str_pad($invoiceId, 9, '0', STR_PAD_LEFT);
        $pdf->Cell(30, 5, $formattedInvoiceId, 0, 1, 'L');

        $pdf->SetTextColor(0, 0, 0);

        /*
        |--------------------------------------------------------------------------
        | FECHA
        |--------------------------------------------------------------------------
        */

        $formattedDate = date('m-d-Y', strtotime($createdAt));

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 5, $formattedDate, 0, 1, 'L');

        /*
        |--------------------------------------------------------------------------
        | IKUSA
        |--------------------------------------------------------------------------
        */

        $x = 160;
        $y = 5;

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY($x, $y);
        $pdf->Cell(0, 4, 'Ikusa LLC', 0, 1);

        $pdf->SetFont('Arial', '', 8);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, '8735 Dunwoody Place, Ste R', 0, 1);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, 'Atlanta, GA 30350', 0, 1);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, 'United States', 0, 1);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, 'EIN: 872680481', 0, 1);

        $pdf->SetX($x);
        $pdf->Cell(0, 4, 'DUNS: 100861837', 0, 1);

        /*
        |--------------------------------------------------------------------------
        | CLIENTE
        |--------------------------------------------------------------------------
        */

        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, 'Client: ', 0, 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode($client['name'] ?? ''), 0, 1);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, 'Tax Id: ', 0, 0);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode($client['tax_id'] ?? ''), 0, 1);

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(20, 5, 'Address: ', 0, 0);

        $pdf->SetX(30);
        $pdf->Cell(0, 5, utf8_decode($client['address'] ?? ''), 0, 1);

        $pdf->SetX(30);
        $pdf->SetFont('Arial', 'B', 10);

        $location = ($client['city'] ?? '') . ', ' . ($client['state'] ?? '') . ', ' . ($client['zip_code'] ?? '');
        $pdf->Cell(0, 5, utf8_decode($location), 0, 1);

        $pdf->SetX(30);
        $pdf->Cell(0, 5, utf8_decode($client['country'] ?? ''), 0, 1);

        /*
        |--------------------------------------------------------------------------
        | PRODUCTOS
        |--------------------------------------------------------------------------
        */

        $pdf->Ln(10);

        $pdf->SetFillColor(255, 69, 0);
        $pdf->SetTextColor(255, 255, 255);

        $pdf->Cell(50, 10, 'Goods/Service', '', 0, 'C', true);
        $pdf->Cell(20, 10, 'Quantity', '', 0, 'C', true);
        $pdf->Cell(35, 10, 'Unit Value', '', 0, 'C', true);
        $pdf->Cell(15, 10, 'Unit', '', 0, 'C', true);
        $pdf->Cell(25, 10, 'Discount (%)', '', 0, 'C', true);
        $pdf->Cell(20, 10, 'Vat Rate', '', 0, 'C', true);
        $pdf->Cell(30, 10, 'Total', '', 1, 'C', true);

        $pdf->SetTextColor(0, 0, 0);

        $subtotal = 0;

        foreach ($details as $detail) {
            $unitValue = (float) ($detail['unit_value'] ?? 0);
            $quantity  = (float) ($detail['quantity'] ?? 0);
            $discount  = (float) ($detail['discount'] ?? 0);
            $vatRate   = (float) ($detail['vat_rate'] ?? 0);

            $balance = $quantity * $unitValue * (1 - $discount / 100) * (1 + $vatRate / 100);
            $subtotal += $balance;

            $pdf->Cell(50, 5, utf8_decode($detail['product_name'] ?? ''), '');
            $pdf->Cell(20, 5, $quantity, '', 0, 'R');
            $pdf->Cell(35, 5, number_format($unitValue, 2), '', 0, 'R');
            $pdf->Cell(15, 5, utf8_decode($detail['unit'] ?? ''), '', 0, 'R');
            $pdf->Cell(25, 5, number_format($discount, 2), '', 0, 'R');
            $pdf->Cell(20, 5, number_format($vatRate, 2), '', 0, 'R');
            $pdf->Cell(30, 5, number_format($balance, 2), '', 1, 'R');

            if (!empty($detail['note'])) {
                $pdf->SetX(10);
                $pdf->MultiCell(50, 5, utf8_decode($detail['note']), '');
            }

            $pdf->Cell(195, 0, '', 'T', 1);
        }

        /*
        |--------------------------------------------------------------------------
        | TOTALES
        |--------------------------------------------------------------------------
        */

        $vat   = 0;
        $total = $subtotal + $vat;

        $pdf->Cell(165, 8, 'Sub-total', '', 0, 'L');
        $pdf->Cell(30, 8, number_format($subtotal, 2), '', 1, 'R');

        $pdf->Cell(165, 8, 'VAT/IVA', '', 0, 'L');
        $pdf->Cell(30, 8, number_format($vat, 2), '', 1, 'R');

        $pdf->Cell(165, 8, 'Total', 'B', 0, 'L');
        $pdf->Cell(30, 8, number_format($total, 2), 'B', 1, 'R');

        /*
        |--------------------------------------------------------------------------
        | LEGAL
        |--------------------------------------------------------------------------
        */

        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(0, 5, 'All amounts are in EUR.', 0, 'L');
        $pdf->MultiCell(0, 5, 'VAT not charged. Reverse charge applies under Article 196 of the EU VAT Directive. Customer is responsible for VAT in Spain.', 0, 'L');

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(0, 5, 'Payment due at the end of the month.', 0, 'L');

        $pdf->Ln(3);

        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(0, 5, utf8_decode('Todos los importes están expresados en euros.'), 0, 'L');
        $pdf->MultiCell(0, 5, utf8_decode('IVA no incluido. Operación sujeta a inversión del sujeto pasivo (Art. 196 Directiva IVA UE). El cliente deberá autoliquidar el IVA en España.'), 0, 'L');

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(0, 5, utf8_decode('Pago al final del mes.'), 0, 'L');

        /*
        |--------------------------------------------------------------------------
        | FOOTER
        |--------------------------------------------------------------------------
        */

        $y = 270;

        $icons = [
            $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rrss/instagram.png',
            $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rrss/facebook.png',
            $_SERVER['DOCUMENT_ROOT'] . '/assets/img/rrss/linkedIn.png'
        ];

        $iconSize   = 5;
        $totalWidth = count($icons) * $iconSize + (count($icons) - 1) * 5;
        $x = (210 - $totalWidth) / 2;

        foreach ($icons as $icon) {
            if (is_file($icon)) {
                $pdf->Image($icon, $x, $y, $iconSize);
            }

            $x += $iconSize + 5;
        }

        /*
        |--------------------------------------------------------------------------
        | OUTPUT
        |--------------------------------------------------------------------------
        */

        if (ob_get_length()) {
            ob_clean();
        }

        $pdf->Output('I', $fileName);
        exit;
    }
}