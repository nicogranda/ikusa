<?php

require_once __DIR__ . '/../../Shared/Model.php';

use Src\Shared\Model;

class RFQ extends Model
{
    public function __construct(mysqli $db)
    {
        parent::__construct($db);
    }

    public function getSuppliersByQuote(int $quoteId): array
    {
        $sql = "
            SELECT
                s.id AS supplier_id,
                s.name AS supplier_name,
                s.email,
                s.phone,
                qi.product_id,
                p.name AS product_name,
                qi.quantity,
                p.unit,
                qi.note
            FROM quotes_details qi
            INNER JOIN products p ON p.id = qi.product_id
            INNER JOIN supplier_products sp 
                ON sp.product_id = qi.product_id AND sp.active = 1
            INNER JOIN suppliers s ON s.id = sp.supplier_id
            WHERE qi.quote_id = ?
            ORDER BY s.id ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();

        $result = $stmt->get_result();

        $suppliers = [];

        while ($row = $result->fetch_assoc()) {

            $id = (int)$row['supplier_id'];

            if (!isset($suppliers[$id])) {
                $suppliers[$id] = [
                    'supplier_id' => $id,
                    'supplier_name' => $row['supplier_name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'products' => []
                ];
            }

            $suppliers[$id]['products'][] = [
                'product_id' => (int)$row['product_id'],
                'product_name' => $row['product_name'],
                'quantity' => (float)$row['quantity'],
                'unit' => $row['unit'],
                'note' => $row['note']
            ];
        }

        return array_values($suppliers);
    }

    public function getQuoteItems(int $quoteId): array
    {
        $stmt = $this->db->prepare("
            SELECT qi.*, p.name, p.unit
            FROM quote_items qi
            INNER JOIN products p ON p.id = qi.product_id
            WHERE qi.quote_id = ?
        ");

        $stmt->bind_param("i", $quoteId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}