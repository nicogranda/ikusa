<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Shared/Model.php';

require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Quotes/Quote.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Clients/Client.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/QuoteDetails/QuoteDetail.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Products/Product.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Shared/OperationData.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Invoices/Invoice.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Invoices/InvoiceDetail.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Auth/User.php';

require_once dirname(__DIR__, 5) . '/app/services/FpdfService.php';


use App\Models\Admin\OperationData;
use App\Models\Admin\Quote;
use App\Models\Admin\Client;
use App\Models\Admin\QuoteDetail;
use App\Models\Admin\Product;
use App\Models\Admin\Invoice;
use App\Models\Admin\InvoiceDetail;
use App\Models\Admin\User;

use App\Services\FpdfService;


class InvoicesController
{
    private $mysqli;
    private $operation;
    private $business;
    private $operation_detail;
    private $product;
    private $user;
    private $require;
    private $invoice_details;


    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;

        $this->operation        = new Quote();
        $this->business         = new Client();
        $this->operation_detail = new QuoteDetail();
        $this->invoice_details  = new InvoiceDetail($this->mysqli);
        $this->product          = new Product();
        $this->user             = new User();
        $this->require          = new Invoice();
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        unset($_SESSION['message']);

        $operationsPerPage = 10;

        $currentPage = isset($_GET['currentPage'])
            ? (int) $_GET['currentPage']
            : 1;

        $offset = ($currentPage - 1) * $operationsPerPage;

        $requires = $this->require->getAllPaginated(
            $operationsPerPage,
            $offset
        );

        $totalPages = ceil(
            $this->require->getTotalInvoices() / $operationsPerPage
        );

        foreach ($requires as $key => $require) {

            $operation = $this->operation->getById(
                $require['quote_id']
            );

            if ($operation) {

                $business = $this->business->getById(
                    $operation['business_id']
                );

                $requires[$key]['business_name'] =
                    $business
                        ? $business['name']
                        : 'Business no encontrado';

                $requires[$key]['business_email'] =
                    $business
                        ? $business['email']
                        : 'N/A';

                $user = $this->user->getById(
                    $require['user_id']
                );

                $requires[$key]['user_alias'] =
                    $user
                        ? $user['username']
                        : 'User no encontrado';

                $amount = $this->operation_detail->getAmount(
                    $require['quote_id']
                );

                $requires[$key]['amount'] = $amount['total'];
            }
        }

        $pageTotal = array_sum(
            array_map(
                function ($r) {
                    return round($r['amount'] ?? 0, 2);
                },
                $requires
            )
        );

        $year = !empty($requires)
            ? (int) date('Y', strtotime($requires[0]['created_at']))
            : (int) date('Y');

        $annualTotal = $this->require->getTotalByYear($year);

        $grandTotal = $this->require->getTotalAll();

        include dirname(__DIR__, 5) . "/app/src/Domains/Admin/Invoices/views/index.php";
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $operation = [
            'quote_id'   => $_GET['operation'],
            'user_id'    => $_SESSION['user_id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $require = $this->require->create($operation);

        if ($require) {

            header(
                "Location: index.php?page=invoices&action=index"
            );

            exit;

        } else {

            echo "Error al crear la orden.";
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    public function search()
    {
        $search = isset($_POST['search'])
            ? trim($_POST['search'])
            : '';

        $month = isset($_POST['month'])
            ? $_POST['month']
            : '';

        $year = isset($_POST['year'])
            ? $_POST['year']
            : '';

        $operationsPerPage = 10;

        $currentPage = isset($_GET['currentPage'])
            ? (int) $_GET['currentPage']
            : 1;

        $offset = ($currentPage - 1) * $operationsPerPage;

        $totalPages  = 1;
        $annualTotal = 0;
        $requires    = [];


        if (!empty($search)) {

            $requires = $this->require->searchById($search);

            $totalPages  = 1;
            $currentPage = 1;

        } elseif (!empty($month) && !empty($year)) {

            $requires = $this->require->searchByDate(
                $month,
                $year,
                $operationsPerPage,
                $offset
            );

            $total = $this->require->getTotalByDateRange(
                $year . '-' . $month . '-01',
                $year . '-' . $month . '-31'
            );

            $totalPages = ceil(
                $total / $operationsPerPage
            );

        } elseif (empty($month) && !empty($year)) {

            $requires = $this->require->searchByYear($year);

            $totalPages  = 1;
            $currentPage = 1;

        } else {

            header(
                "Location: index.php?page=invoices&action=index"
            );

            exit;
        }


        if (!empty($requires)) {

            foreach ($requires as &$require) {

                $operation = $this->operation->getById(
                    $require['quote_id'] ?? null
                );

                $business = $this->business->getById(
                    $operation['business_id'] ?? null
                );

                $require['business_name'] =
                    $business
                        ? $business['name']
                        : 'Business no found';

                $require['business_email'] =
                    $business
                        ? $business['email']
                        : 'N/A';

                $amount = $this->operation_detail->getAmount(
                    $require['quote_id']
                );

                $require['amount'] = $amount['total'];
            }

            unset($require);


            $pageTotal = array_sum(
                array_map(
                    function ($r) {
                        return round(
                            $r['amount'] ?? 0,
                            2
                        );
                    },
                    $requires
                )
            );


            if (empty($month) && !empty($year)) {

                $annualTotal = $pageTotal;

            } else {

                $annualTotal = $this->require->getTotalByYear(
                    $year ?: date('Y')
                );
            }

            $year = $year ?: date('Y');

            $grandTotal = $this->require->getTotalAll();

            include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Invoices/views/index.php';
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        if ($id <= 0) {

            echo "ID no valido: {$id}";

            return;
        }

        $order = $this->require->getById($id);

        if (!$order) {

            echo "Factura no encontrada";

            return;
        }

        $operation = $this->operation->getById(
            $order['quote_id']
        );

        if ($operation) {

            $business = $this->business->getById(
                $operation['business_id']
            );

            $operation['business_name'] =
                $business
                    ? $business['name']
                    : 'Business no encontrado';

            $operation['business_email'] =
                $business
                    ? $business['email']
                    : 'N/A';

            $operation_details =
                $this->operation_detail->getByItemId(
                    'quote_id',
                    $operation['id']
                );


            foreach ($operation_details as &$operation_detail) {

                $product = $this->product->getByItemId(
                    'id',
                    $operation_detail['product_id']
                );

                $operation_detail['product_name'] =
                    $product
                        ? $product[0]['name']
                        : 'Product not found';

                $operation_detail['unit'] =
                    $product
                        ? $product[0]['unit']
                        : 'N/A';
            }

            unset($operation_detail);

            include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Invoices/views/show.php';

        } else {

            echo "No se encontr車 la cotizaci車n con el ID {$id}.";
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    public function pdf($id)
    {
        if ($id <= 0) {

            http_response_code(400);

            exit('ID no v芍lido');
        }


        // Factura

        $invoice = $this->require->getById($id);

        if (!$invoice) {

            http_response_code(404);

            exit('Factura no encontrada');
        }


        // Cotizaci車n

        $operation = $this->operation->getById(
            $invoice['quote_id']
        );

        if (!$operation) {

            http_response_code(404);

            exit('Cotizaci車n no encontrada');
        }


        // Cliente

        $business = $this->business->getById(
            $operation['business_id']
        );

        if (!$business) {

            http_response_code(404);

            exit('Cliente no encontrado');
        }


        // Detalles de factura

$details = $this->operation_detail
    ->getByItemId(
        'quote_id',
        $operation['id']
    );


        // Productos

        foreach ($details as &$detail) {

            $product = $this->product
                ->getByItemId(
                    'id',
                    $detail['product_id']
                );

            $detail['product_name'] =
                $product[0]['name']
                ?? 'Product not found';

            $detail['unit'] =
                $product[0]['unit']
                ?? 'N/A';
        }

        unset($detail);


        // Generar PDF

        $pdfService = new FpdfService();

        $pdfService->invoice(
            $invoice,
            $operation,
            $business,
            $details
        );
    }


    /*
    |--------------------------------------------------------------------------
    | MAIL
    |--------------------------------------------------------------------------
    */

    public function mail($id)
    {
        if ($id <= 0) {

            echo "ID no v芍lido: {$id}";

            return;
        }


        // 1. Factura

        $order = $this->require->getById($id);

        if (!$order) {

            echo "Factura no encontrada";

            return;
        }


        // 2. Cotizaci車n asociada

        $operation = $this->operation->getById(
            $order['quote_id']
        );

        if (!$operation) {

            echo "No se encontr車 la cotizaci車n con el ID {$order['quote_id']}";

            return;
        }


        // 3. Cliente

        $business = $this->business->getById(
            $operation['business_id']
        );

        $operation['business_name'] =
            $business['name']
            ?? 'Business no encontrado';

        $operation['business_email'] =
            $business['email']
            ?? 'N/A';


        /*
        |--------------------------------------------------------------------------
        | LINK SEGURO PDF
        |--------------------------------------------------------------------------
        */

        require_once dirname(__DIR__, 5) . '/app/config/invoice_link.php';

        $invoiceToken = hash_hmac(
            'sha256',
            $order['id'] . $operation['business_email'],
            INVOICE_LINK_SECRET
        );

        $invoiceLink =
            "https://ikusa.net/?invoice={$order['id']}&client={$invoiceToken}";


        // 4. Detalles factura

        $operation_details =
            $this->invoice_details->getByItemId(
                'invoice_id',
                $order['id']
            );


        // 5. Productos

        foreach ($operation_details as &$detail) {

            $product = $this->product->getByItemId(
                'id',
                $detail['product_id']
            );

            $detail['product_name'] =
                $product[0]['name']
                ?? 'Product not found';

            $detail['unit'] =
                $product[0]['unit']
                ?? 'N/A';
        }

        unset($detail);


        /*
        |--------------------------------------------------------------------------
        | MAIL
        |--------------------------------------------------------------------------
        */

        $mailerId     = "Ikusa LLC";
        $mailerTo     = $operation['business_email'];
        $mailerFrom   = 'contact@ikusa.net';
        $mailerToToo  = 'ikusa.ads@gmail.com';
        $mailerReplay = $mailerFrom;

        $subject = "Invoice {$order['id']}";


        require_once dirname(__DIR__, 5) . '/app/config/email.php';


        // $invoiceLink est芍 disponible para mail.php

        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Invoices/views/mail.php';


        // Sistema actual de env赤o.
        // Lo dejamos funcionando por ahora.

        include dirname(__DIR__, 5) . '/app/libraries/inc_phpmailer.php';


        $_SESSION['message'] =
            "Email enviado correctamente a {$operation['business_email']}";


        header(
            "Location: index.php?page=invoices&action=show&id={$order['id']}"
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {
        if ($this->require->delete($id)) {

            header(
                "Location: index.php?page=order&action=index"
            );

            exit;
        }
    }
}