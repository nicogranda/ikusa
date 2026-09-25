<?php
namespace App\Models\Admin;

// Primero requerimos la clase Model
require_once __DIR__ . '/../../libraries/admin/Model.php';

use App\Libraries\Admin\Model;

class InvoiceDetail extends Model
{
    protected $table = 'invoices_details';

    public function __construct($mysqli = null)
    {
        parent::__construct();
        if ($mysqli) {
            $this->mysqli = $mysqli;
        }
    }
}
