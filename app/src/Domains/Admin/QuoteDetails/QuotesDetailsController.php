<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Shared/Model.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Quotes/Quote.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Clients/Client.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/QuoteDetails/QuoteDetail.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Products/Product.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Categories/Category.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Shared/OperationData.php';

use App\Models\Admin\OperationData;
use App\Models\Admin\Quote;
use App\Models\Admin\Client;
use App\Models\Admin\QuoteDetail;
use App\Models\Admin\Category;
use App\Models\Admin\Product;

class QuotesDetailsController
{
    private QuoteDetail $quoteDetail;
    private Category $category;
    private Product $product;

    public function __construct()
    {
        $this->quoteDetail = new QuoteDetail();
        $this->category = new Category();
        $this->product = new Product();
    }

    // ───────── Crear nuevo detalle ─────────
    public function create($item)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $item = [
                'quote_id'    => $_POST['quote_id'],
                'product_id'  => $_POST['product_id'],
                'quantity'    => $_POST['quantity'],
                'unit_value'  => $_POST['unit_value'],
                'discount'    => $_POST['discount'],
                'vat_rate'    => $_POST['vat_rate'],
                'note'        => $_POST['note'],
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s')
            ];

            $this->quoteDetail->create($item);

            header("Location: index.php?page=quotes&action=show&id=" . $item['quote_id']);
            exit;

        } else {

            $categories = $this->category->getAll();
            $products   = $this->product->getAll();

            include dirname(__DIR__, 5) . "/app/src/Domains/Admin/QuoteDetails/views/create.php";
        }
    }

    // ───────── Eliminar detalle(s) ─────────
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }

        $quoteId = $_POST['operation_id'] ?? null;
        $itemIds = $_POST['del'] ?? [];

        if (!is_numeric($quoteId) || empty($itemIds)) {
            $_SESSION['message'] = 'No se seleccionaron items para eliminar';
            header("Location: index.php?page=quotes&action=update&id=" . $quoteId);
            exit;
        }

        $quoteId = (int)$quoteId;
        $this->quoteDetail->beginTransaction();

        try {
            // Eliminar items seleccionados
            foreach ($itemIds as $itemId) {
                if (!is_numeric($itemId)) {
                    throw new Exception('ID de item inválido: ' . $itemId);
                }
                $this->quoteDetail->delete((int)$itemId);
            }

            
            // Recalcular totales
            $amounts = $this->quoteDetail->getAmount($quoteId);
            
            // Actualizar quote (tabla correcta)
            $quote = new Quote(); // ✅ correcto: tabla quotes
            // $quote->updateById($quoteId, [
            //     'total' => $amounts['total'],
            //     'vat'   => $amounts['vat']
            // ]);

            $this->quoteDetail->commitTransaction();
            $_SESSION['message'] = 'Items eliminados correctamente';

        } catch (Exception $e) {
            $this->quoteDetail->rollbackTransaction();
            $_SESSION['message'] = 'Error al eliminar items: ' . $e->getMessage();
        }

        header("Location: index.php?page=quotes&action=update&id=" . $quoteId);
        exit;
    }
}