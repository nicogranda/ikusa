<?php

/*
|--------------------------------------------------------------------------
| DATOS DEL ENLACE
|--------------------------------------------------------------------------
*/

$invoiceId  = (int) ($_GET['invoice'] ?? 0);
$clientToken = $_GET['client'] ?? '';

if ($invoiceId <= 0 || $clientToken === '') {
    http_response_code(400);
    exit('Solicitud inválida');
}


/*
|--------------------------------------------------------------------------
| CONFIGURACIÓN TOKEN
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../../../../config/invoice_link.php';


/*
|--------------------------------------------------------------------------
| MODELOS
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/../../../../libraries/admin/Model.php';

require_once __DIR__ . '/../../../../models/admin/Invoice.php';
require_once __DIR__ . '/../../../../models/admin/Quote.php';
require_once __DIR__ . '/../../../../models/admin/Client.php';
require_once __DIR__ . '/../../../../models/admin/QuoteDetail.php';
require_once __DIR__ . '/../../../../models/admin/Product.php';

require_once __DIR__ . '/../../../../services/FpdfService.php';


use App\Models\Admin\Invoice;
use App\Models\Admin\Quote;
use App\Models\Admin\Client;
use App\Models\Admin\QuoteDetail;
use App\Models\Admin\Product;

use App\Services\FpdfService;


/*
|--------------------------------------------------------------------------
| INSTANCIAR MODELOS
|--------------------------------------------------------------------------
*/

$invoiceModel     = new Invoice();
$quoteModel       = new Quote();
$clientModel      = new Client();
$quoteDetailModel = new QuoteDetail();
$productModel     = new Product();


/*
|--------------------------------------------------------------------------
| FACTURA
|--------------------------------------------------------------------------
*/

$invoice = $invoiceModel->getById($invoiceId);

if (!$invoice) {
    http_response_code(404);
    exit('Factura no encontrada');
}


/*
|--------------------------------------------------------------------------
| COTIZACIÓN
|--------------------------------------------------------------------------
*/

$quote = $quoteModel->getById(
    $invoice['quote_id']
);

if (!$quote) {
    http_response_code(404);
    exit('Cotización no encontrada');
}


/*
|--------------------------------------------------------------------------
| CLIENTE
|--------------------------------------------------------------------------
*/

$business = $clientModel->getById(
    $quote['business_id']
);

if (!$business) {
    http_response_code(404);
    exit('Cliente no encontrado');
}


/*
|--------------------------------------------------------------------------
| VALIDAR TOKEN
|--------------------------------------------------------------------------
*/

if (empty($business['email'])) {
    http_response_code(403);
    exit('Cliente sin email válido');
}

$expectedToken = hash_hmac(
    'sha256',
    $invoiceId . $business['email'],
    INVOICE_LINK_SECRET
);

if (!hash_equals($expectedToken, $clientToken)) {
    http_response_code(403);
    exit('Enlace no válido');
}


/*
|--------------------------------------------------------------------------
| DETALLES DE LA COTIZACIÓN
|--------------------------------------------------------------------------
|
| La factura toma los conceptos desde quotes_details,
| igual que hacía el invoice.php original.
|
*/

$details = $quoteDetailModel->getByItemId(
    'quote_id',
    $quote['id']
);


/*
|--------------------------------------------------------------------------
| PRODUCTOS
|--------------------------------------------------------------------------
*/

foreach ($details as &$detail) {

    $product = $productModel->getByItemId(
        'id',
        $detail['product_id']
    );

    $detail['product_name'] =
        $product[0]['name'] ?? 'Product not found';

    $detail['unit'] =
        $product[0]['unit'] ?? 'N/A';
}

unset($detail);


/*
|--------------------------------------------------------------------------
| GENERAR PDF
|--------------------------------------------------------------------------
*/

$pdfService = new FpdfService();

$pdfService->invoice(
    $invoice,
    $quote,
    $business,
    $details
);

exit;