<?php

namespace App\Models\Admin;

use App\Libraries\Admin\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    public function __construct()
    {
        parent::__construct();
    }


    public function getByProducts(array $productIds): array
    {
        if (!$productIds) return [];
    
        $placeholders = implode(',', array_fill(0, count($productIds), '?'));
        $types = str_repeat('i', count($productIds));
    
        $sql = "
            SELECT DISTINCT 
                s.id, 
                s.name,
                s.email
            FROM suppliers s
            INNER JOIN supplier_products sp ON sp.supplier_id = s.id
            WHERE sp.product_id IN ($placeholders)
            ORDER BY s.name ASC
        ";
    
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param($types, ...$productIds);
        $stmt->execute();
    
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}