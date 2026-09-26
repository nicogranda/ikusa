<?php
namespace App\Models\Admin;
class Collection {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function save($data) {
        $stmt = $this->mysqli->prepare("
            INSERT INTO collections 
            (quote_id, amount, payment_method, bank_name, transaction_number, payment_date, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");

    
        if (!$stmt) {
            die("Error en prepare: " . $this->mysqli->error);
        }

        // Asegúrate de que los campos opcionales tengan al menos ''
        $bank_name = $data['bank_name'] ?? null;
        $transaction_number = $data['transaction_number'] ?? null;
        $payment_date = $data['payment_date'] ?? null;

        $stmt->bind_param(
            "idssss",
            $data['quote_id'],          // i → int
            $data['amount'],            // d → decimal
            $data['payment_method'],    // s
            $bank_name,                 // s
            $transaction_number,        // s
            $payment_date               // s
        );


        $result = $stmt->execute();

        if (!$result) {
            die("Error en execute: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }
    
    public function getByQuoteId($quote_id) {
        $stmt = $this->mysqli->prepare("SELECT * FROM collections WHERE quote_id = ? ORDER BY payment_date ASC");
    
        if (!$stmt) {
            die("Error en prepare: " . $this->mysqli->error);
        }
    
        $stmt->bind_param("i", $quote_id);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $collections = [];
    
        while ($row = $result->fetch_assoc()) {
            $collections[] = $row;
        }
    
        $stmt->close();
        return $collections;
    }

}
