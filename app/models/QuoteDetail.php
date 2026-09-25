<?php
// models/QuoteDetail.php

class QuoteDetail {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    // Crear un detalle de cotización
    public function create($quote_id, $product_id, $quantity, $unit_value) {
        $sql = "INSERT INTO quotes_details (quote_id, product_id, quantity, unit_value, created_at, updated_at) 
                VALUES (?, ?, ?, ?, NOW(), NOW())";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('iiid', $quote_id, $product_id, $quantity, $unit_value);
        return $stmt->execute();
    }

    // Obtener detalles de cotización por ID de cotización
    public function findByQuoteId($quote_id) {
        $sql = "SELECT qd.id, qd.product_id, qd.quantity, qd.unit_value, qd.created_at, p.name AS product_name, p.unit AS product_unit
                FROM quotes_details qd
                JOIN products p ON qd.product_id = p.id
                WHERE qd.quote_id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $quote_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Actualizar un detalle de cotización
    public function update($id, $quantity, $unit_value) {
        $sql = "UPDATE quotes_details SET quantity = ?, unit_value = ?, updated_at = NOW() WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('idi', $quantity, $unit_value, $id);
        return $stmt->execute();
    }

    // Verificar si el detalle de cotización ya existe
    public function exists($quote_id, $product_id) {
        $sql = "SELECT * FROM quotes_details WHERE quote_id = ? AND product_id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('ii', $quote_id, $product_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}
?>
