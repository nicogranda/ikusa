<?php
namespace App\Models\Admin;
use App\Libraries\Admin\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    
    public function getAllPaginated($limit, $offset) 
    {
        $sql = "SELECT * FROM invoices ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getTotalInvoices() {
        $result = $this->mysqli->query("SELECT COUNT(*) as total FROM invoices");
        return $result->fetch_assoc()['total'] ?? 0;
    }

    public function getTotalAll() {
        $sql = "SELECT SUM(
                    ROUND(
                        qd.quantity * qd.unit_value * (1 - qd.discount/100) * (1 + qd.vat_rate/100),
                    2)
                ) as total
                FROM invoices i
                JOIN quotes_details qd ON qd.quote_id = i.quote_id";
        $result = $this->mysqli->query($sql);
        return $result->fetch_assoc()['total'] ?? 0;
    }

public function getTotalByYear($year) {
    $sql = "SELECT SUM(
                ROUND(
                    qd.quantity * qd.unit_value * (1 - qd.discount/100) * (1 + qd.vat_rate/100),
                2)
            ) as total
            FROM invoices i
            JOIN quotes_details qd ON qd.quote_id = i.quote_id
            WHERE YEAR(i.created_at) = ?";
    $stmt = $this->mysqli->prepare($sql);
    $stmt->bind_param('i', $year);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result['total'] ?? 0;
}
    
    public function searchByYear($year) {
        $sql = "SELECT * FROM invoices WHERE YEAR(created_at) = ? ORDER BY created_at DESC";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $year);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getClientsAlphabetically(): array
    {
        $result = $this->mysqli->query('SELECT id, name FROM clients ORDER BY name ASC, id ASC');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAmountForQuote(int $quoteId): float
    {
        $stmt = $this->mysqli->prepare(
            'SELECT COALESCE(SUM(ROUND(quantity * unit_value
                * (1 - discount / 100) * (1 + vat_rate / 100), 2)), 0) AS total
             FROM quotes_details WHERE quote_id = ?'
        );
        $stmt->bind_param('i', $quoteId);
        $stmt->execute();
        return (float) ($stmt->get_result()->fetch_assoc()['total'] ?? 0);
    }

    /** Uses the same per-line rounding as getTotalByYear(). */
    public function getInvoicesByClientForPeriod(int $year, ?int $month = null): array
    {
        $start = sprintf('%04d-%02d-01', $year, $month ?? 1);
        $end = $month === null
            ? sprintf('%04d-01-01', $year + 1)
            : date('Y-m-d', strtotime($start . ' +1 month'));

        $sql = "SELECT i.id, i.quote_id, i.created_at,
                       q.business_id AS client_id, c.name AS client_name,
                       COALESCE(SUM(ROUND(
                           qd.quantity * qd.unit_value
                           * (1 - qd.discount / 100)
                           * (1 + qd.vat_rate / 100), 2
                       )), 0) AS amount
                FROM invoices i
                LEFT JOIN quotes q ON q.id = i.quote_id
                LEFT JOIN clients c ON c.id = q.business_id
                LEFT JOIN quotes_details qd ON qd.quote_id = i.quote_id
                WHERE i.created_at >= ? AND i.created_at < ?
                GROUP BY i.id, i.quote_id, i.created_at, q.business_id, c.name
                ORDER BY (c.name IS NULL) ASC, c.name ASC, c.id ASC,
                         i.created_at DESC, i.id DESC";

        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('ss', $start, $end);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
}
?>
