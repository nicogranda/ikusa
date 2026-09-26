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
    
}
?>
