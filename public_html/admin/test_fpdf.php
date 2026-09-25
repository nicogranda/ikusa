<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/fpdf/fpdf.php'; // Ajusta ruta según tu estructura
require_once __DIR__ . '/../../vendor/autoload.php';

use setasign\Fpdi\Fpdi;

$pdf = new Fpdi();
// $pdf->AddPage();

// // Define la fuente, mejor una que soporte UTF-8 (o usa un método para UTF-8):
// $pdf->SetFont('Arial', '', 12);

// // Convierte el texto a ISO-8859-1 porque FPDF clásico no maneja UTF-8 directamente
// $texto = utf8_decode('¡Hola desde FPDI con FPDF manual!');

// $pdf->Cell(0, 10, $texto, 0, 1);

// $pdf->Output();

// require 'vendor/autoload.php';

// use setasign\Fpdi\Tcpdf\Fpdi;

// Crear instancia
// $pdf = new Fpdi();

// Cargar la plantilla PDF como fondo
$pageCount = $pdf->setSourceFile('fpdf/f5472.pdf');
$templateId = $pdf->importPage(1);

$pdf->AddPage();
$pdf->useTemplate($templateId, 0, 0, 210); // ancho A4

// Agregar contenido encima
$pdf->SetFont('Helvetica', '', 12);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetXY(20, 50);
$pdf->Cell(0, 10, 'Este texto está encima del fondo');

$pdf->Output('I', 'documento-con-fondo.pdf');
