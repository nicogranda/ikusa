<?php
declare(strict_types=1);

namespace Src\Domains\Quote;

use mysqli;

class QuoteDetail
{
    private mysqli $db;
    protected string $table = 'quotes_details';

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    /**
     * Obtiene el total de un quote por su ID
     */
    public function getAmount(int $quoteId): array
    {
        $total = 0;
        $vat = 0;

        $query = "SELECT * FROM {$this->table} WHERE quote_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $quantity = (float) $row['quantity'];
            $unit_value = (float) $row['unit_value'];
            $discount = (float) $row['discount'];
            $vat_rate = (float) $row['vat_rate'];

            $vat_item = $quantity * $unit_value * (1 - $discount / 100) * ($vat_rate / 100);
            $balance = $quantity * $unit_value * (1 - $discount / 100) + $vat_item;

            $vat += $vat_item;
            $total += $balance;
        }

        $stmt->close();

        return ['total' => $total, 'vat' => $vat];
    }

    /**
     * Obtener todos los detalles de un quote
     */
    public function getByQuoteId(int $quoteId): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM {$this->table}
            WHERE quote_id = ?
            ORDER BY position ASC, id ASC
        ");
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }
}