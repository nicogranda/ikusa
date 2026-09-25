<?php

require_once __DIR__ . '/../src/Shared/Model.php';

use Src\Shared\Model;

class Chat extends Model {

    public string $table = 'chat_history';

    public function __construct($connection)
    {
        parent::__construct($connection);
    }


    // ===============================
    // Guardar mensaje
    // ===============================
    public function saveMessage($sessionId, $role, $message)
    {
        return $this->create([
            'session_id' => $sessionId,
            'role'       => $role,
            'message'    => $message,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    // ===============================
    // Historial (últimos mensajes)
    // ===============================
    public function getHistory($sessionId, $limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT role, message 
            FROM {$this->table}
            WHERE session_id = ?
            ORDER BY id DESC
            LIMIT ?
        ");

        $stmt->bind_param("si", $sessionId, $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        $messages = [];

        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        return array_reverse($messages);
    }

    // ===============================
    // Catálogo productos (JSON)
    // ===============================
    public function getProductsCatalog()
    {
        $stmt = $this->db->prepare("
            SELECT name, unit_value, unit 
            FROM products
        ");
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $products = [];
    
        while ($row = $result->fetch_assoc()) {
            $products[] = [
                'name'  => $row['name'] ?? '',
                'price' => $row['unit_value'] ?? 0,
                'unit'  => $row['unit'] ?? ''
            ];
        }
    
        return $products;
    }
}