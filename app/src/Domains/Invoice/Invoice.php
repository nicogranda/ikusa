<?php
namespace Src\Domains\Invoice;

use Src\Shared\Model;
use mysqli;

class Invoice extends Model
{
    protected string $table = 'invoices';

    public function __construct(mysqli $db)
    {
        parent::__construct($db);
    }

    public function getByDateRange(string $startDate, string $endDate): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} WHERE DATE(created_at) BETWEEN ? AND ? ORDER BY created_at DESC
        ");
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getByYear(string $year): array
    {
        $start = $year . '-01-01';
        $end   = $year . '-12-31';
        return $this->getByDateRange($start, $end);
    }

    public function getByMonth(string $year, string $month): array
    {
        $start = "{$year}-{$month}-01";
        $end   = date("Y-m-t", strtotime($start));
        return $this->getByDateRange($start, $end);
    }
}