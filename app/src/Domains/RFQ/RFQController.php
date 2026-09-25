<?php

require_once __DIR__ . '/RFQ.php';

class RFQController
{
    private RFQ $rfq;

    public function __construct(mysqli $db)
    {
        $this->rfq = new RFQ($db);
    }

    public function create(): void
    {
        global $mysqli;

        $quoteId = (int)($_GET['quote'] ?? 0);
        $selectedSuppliers = $_POST['suppliers'] ?? [];

        if ($quoteId <= 0) {
            die('Quote ID inválido');
        }

        $suppliers = $this->rfq->getSuppliersByQuote($quoteId);

        if (empty($suppliers)) {
            die('No hay suppliers disponibles');
        }

        if (!empty($selectedSuppliers)) {

            $selectedSuppliers = array_map('intval', $selectedSuppliers);

            $suppliers = array_filter($suppliers, function ($s) use ($selectedSuppliers) {
                return in_array((int)$s['supplier_id'], $selectedSuppliers, true);
            });
        }

        foreach ($suppliers as $supplier) {
            $this->sendRFQToSupplier($supplier);
        }

        echo "RFQ generado correctamente";
    }

    private function sendRFQToSupplier(array $supplier): void
    {
        echo "RFQ enviado a: " . $supplier['supplier_name'] . "<br>";
    }
}