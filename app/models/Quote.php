<?php
// models/Quote.php

class Quote {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    // Crear una nueva cotización
    public function create($client_id, $created_at, $updated_at) {
        $sql = "INSERT INTO quotes (client_id, created_at, updated_at) 
                VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('iss', $client_id, $created_at, $updated_at);
        if ($stmt->execute()) {
            return $this->mysqli->insert_id; // Retornar el ID de la cotización recién creada
        }
        return false;
    }

    // Obtener una cotización por ID
    public function findById($id) {
        $sql = "SELECT * FROM quotes WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Obtener todas las cotizaciones
    public function findAll() {
        $sql = "SELECT * FROM quotes";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    // Actualizar una cotización
    public function update($id, $client_id, $created_at, $updated_at) {
        $sql = "UPDATE quotes SET client_id = ?, created_at = ?, updated_at = ? WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('issi', $client_id, $created_at, $updated_at, $id);
        return $stmt->execute();
    }
}
?>
