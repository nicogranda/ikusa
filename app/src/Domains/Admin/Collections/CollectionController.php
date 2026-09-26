<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Shared/Model.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Collections/Collection.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Quotes/Quote.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Clients/Client.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/QuoteDetails/QuoteDetail.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Products/Product.php';

use App\Models\Admin\Collection;
use App\Models\Admin\Quote;
use App\Models\Admin\Client;
use App\Models\Admin\QuoteDetail;
use App\Models\Admin\Product;

class CollectionController
{
    private $mysqli;
    private Collection $collection;
    private Quote $quote;
    private Client $client;
    private QuoteDetail $quoteDetail;
    private Product $product;

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
        $this->collection = new Collection($mysqli);
        $this->quote      = new Quote();
        $this->client     = new Client();
        $this->quoteDetail = new QuoteDetail();
        $this->product     = new Product();
    }

    /**
     * INDEX
     */
    public function index($quote_id = null)
    {
        $collections = $quote_id
            ? $this->collection->getByQuoteId($quote_id)
            : $this->collection->getAll();

        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Collections/views/index.php';
    }

    /**
     * SHOW
     */
    public function show($id)
    {
        $collection = $this->collection->getById($id);

        if (!$collection) {
            die("Cobranza no encontrada.");
        }

        $quote = $this->quote->getById($collection['quote_id']);
        $client = $this->client->getById($quote['business_id']);

        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Collections/views/show.php';
    }

    /**
     * CREATE (HTML normal)
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $quote_id = $_POST['quote_id'];
            $amount   = $_POST['amount'];
            $method   = $_POST['payment_method'];

            $data = [
                'quote_id'           => $quote_id,
                'amount'             => $amount,
                'payment_method'     => $method,
                'bank_name'          => $_POST['bank_name'] ?? null,
                'transaction_number' => $_POST['transaction_number'] ?? null,
                'payment_date'       => $_POST['payment_date'] ?? date('Y-m-d'),
            ];

            $this->collection->save($data);

            header("Location: index.php?page=collections&action=show&id={$quote_id}");
            exit;
        }

        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Collections/views/create.php';
    }

    /**
     * UPDATE
     */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'amount'             => $_POST['amount'],
                'payment_method'    => $_POST['payment_method'],
                'bank_name'         => $_POST['bank_name'] ?? null,
                'transaction_number'=> $_POST['transaction_number'] ?? null,
                'payment_date'      => $_POST['payment_date'] ?? null
            ];

            $this->collection->update($id, $data);

            $collection = $this->collection->getById($id);

            header("Location: index.php?page=collections&action=show&id={$collection['quote_id']}");
            exit;
        }

        $collection = $this->collection->getById($id);
        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Collections/views/edit.php';
    }

    /**
     * DELETE
     */
    public function delete($id)
    {
        $collection = $this->collection->getById($id);

        if (!$collection) {
            die("Cobranza no encontrada.");
        }

        $this->collection->delete($id);

        header("Location: index.php?page=collections&action=index");
        exit;
    }

    /**
     * PROCESS (AJAX ONLY - JSON CLEAN)
     */
    public function process()
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);

            echo json_encode([
                'status'  => 'error',
                'message' => 'Método no permitido'
            ]);
            exit;
        }

        try {

            $quote_id = $_POST['quote_id']
                     ?? $_POST['operation_id']
                     ?? null;

            $amount = $_POST['amount']
                   ?? $_POST['amount_partial']
                   ?? null;

            $method = $_POST['payment_method'] ?? null;

            if (!$quote_id || !$amount || !$method) {
                throw new Exception('Datos incompletos para registrar el pago');
            }

            $data = [
                'quote_id'           => (int) $quote_id,
                'amount'             => (float) $amount,
                'payment_method'     => $method,
                'bank_name'          => $_POST['bank_name'] ?? null,
                'transaction_number' => $_POST['transaction_number'] ?? null,
                'payment_date'       => $_POST['payment_date'] ?? date('Y-m-d')
            ];

            $this->collection->save($data);

            echo json_encode([
                'status'   => 'success',
                'message'  => 'Pago registrado correctamente',
                'quote_id' => $quote_id
            ]);

            exit;

        } catch (Exception $e) {

            http_response_code(500);

            echo json_encode([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);

            exit;
        }
    }

    /**
     * PRINT
     */
    public function print($quote_id)
    {
        $quote = $this->quote->getById($quote_id);
        $client = $this->client->getById($quote['business_id']);
        $collections = $this->collection->getByQuoteId($quote_id);

        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Collections/views/print.php';
    }
}