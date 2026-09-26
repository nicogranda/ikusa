<?php

namespace App\Controllers\Admin;

require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Shared/Model.php';
require_once dirname(__DIR__, 5) . '/app/src/Domains/Admin/Suppliers/Supplier.php';

use App\Models\Admin\Supplier;

class RfqController
{
    public function create()
    {
        global $mysqli;

        $quoteId = isset($_GET['quote']) ? (int)$_GET['quote'] : 0;

        if (!$quoteId) {
            die('Quote inválido');
        }

        // 1. productos
        $sql = "SELECT DISTINCT product_id FROM quotes_details WHERE quote_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();

        $res = $stmt->get_result();

        $productIds = [];
        while ($row = $res->fetch_assoc()) {
            $productIds[] = (int)$row['product_id'];
        }

        if (empty($productIds)) {
            die('No hay productos');
        }

        // 2. suppliers
        $supplierModel = new Supplier();
        $suppliers = $supplierModel->getByProducts($productIds);
        
        // 3. items
        $sql = "
            SELECT 
                qd.*, 
                p.name AS product_name,
                p.unit
            FROM quotes_details qd
            LEFT JOIN products p ON p.id = qd.product_id
            WHERE qd.quote_id = ?
        ";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();

        $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        require dirname(__DIR__, 5) . '/app/src/Domains/Admin/Rfq/views/create.php';
    }
    
    public function store()
    {
        global $mysqli;
    
        $quoteId = isset($_POST['quote_id']) ? (int)$_POST['quote_id'] : 0;
        $suppliers = $_POST['suppliers'] ?? [];
    
        if (!$quoteId || empty($suppliers)) {
            die('Datos inválidos');
        }
    
        $mysqli->begin_transaction();
    
        try {
    
            // 1. Crear RFQ
            $stmt = $mysqli->prepare("
                INSERT INTO rfqs (quote_id, created_at, status)
                VALUES (?, NOW(), 'draft')
            ");
            $stmt->bind_param('i', $quoteId);
            $stmt->execute();
    
            $rfqId = $mysqli->insert_id;
    
            // 2. Insertar suppliers
            $stmt = $mysqli->prepare("
                INSERT INTO rfq_suppliers (rfq_id, supplier_id)
                VALUES (?, ?)
            ");
    
            foreach ($suppliers as $supplierId) {
                $supplierId = (int)$supplierId;
                $stmt->bind_param('ii', $rfqId, $supplierId);
                $stmt->execute();
            }
    
            // 3. Copiar items correctamente (AQUÍ ESTABA EL ERROR)
            $stmt = $mysqli->prepare("
                INSERT INTO rfq_items (rfq_id, item_id, description, qty, unit)
                SELECT 
                    ?, 
                    qd.id,
                    qd.note,
                    qd.quantity,
                    p.unit
                FROM quotes_details qd
                LEFT JOIN products p ON p.id = qd.product_id
                WHERE qd.quote_id = ?
            ");
    
            $stmt->bind_param('ii', $rfqId, $quoteId);
            $stmt->execute();
    
            $mysqli->commit();

            // 🔥 aquí llamas al mail
            $this->mail($rfqId);
            
            exit;
    
            //header("Location: index.php?page=rfq&action=view&id=" . $rfqId);
            //exit;
    
        } catch (\Exception $e) {
            $mysqli->rollback();
            die("Error: " . $e->getMessage());
        }
    }
public function mail($rfqId)
{
    if ($rfqId <= 0) {
        echo "ID no válido";
        return;
    }

    global $mysqli;

    // 1. RFQ
    $stmt = $mysqli->prepare("SELECT * FROM rfqs WHERE id = ?");
    $stmt->bind_param('i', $rfqId);
    $stmt->execute();
    $rfq = $stmt->get_result()->fetch_assoc();

    if (!$rfq) {
        echo "RFQ no encontrado";
        return;
    }

    // 2. Items del RFQ
    $stmt = $mysqli->prepare("
        SELECT 
            ri.*, 
            p.name AS product_name
        FROM rfq_items ri
        LEFT JOIN quotes_details qd ON qd.id = ri.item_id
        LEFT JOIN products p ON p.id = qd.product_id
        WHERE ri.rfq_id = ?
    ");
    $stmt->bind_param('i', $rfqId);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // 3. Suppliers
    $stmt = $mysqli->prepare("
        SELECT s.*
        FROM rfq_suppliers rs
        INNER JOIN suppliers s ON s.id = rs.supplier_id
        WHERE rs.rfq_id = ?
    ");
    $stmt->bind_param('i', $rfqId);
    $stmt->execute();
    $suppliers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (empty($suppliers)) {
        echo "No hay suppliers asociados";
        return;
    }

    // 🔥 Credenciales (CORREGIDO)
    require_once dirname(__DIR__, 5) . '/app/config/email.php';

    foreach ($suppliers as $supplier) {

        if (empty($supplier['email'])) {
            continue; // evita errores silenciosos
        }

        $mailerId     = "Ikusa RFQ";
        $mailerTo     = $supplier['email'];
        $mailerFrom   = 'contact@ikusa.net';
        $mailerToToo  = 'ikusa.ads@gmail.com';
        $mailerReplay = $mailerFrom;

        $subject = "RFQ #{$rfqId} - Request for Quotation";

        // generar body

     include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Rfq/views/mail.php';

        // enviar
        include dirname(__DIR__, 5) . '/app/libraries/inc_phpmailer.php';
    }

    // actualizar estado
    $stmt = $mysqli->prepare("UPDATE rfqs SET status = 'sent' WHERE id = ?");
    $stmt->bind_param('i', $rfqId);
    $stmt->execute();

    // redirect final
    header("Location: index.php?page=rfq&action=view&id={$rfqId}");
    exit;
}
}