<?php

namespace Src\Shared;

use mysqli;

class Model
{
    protected mysqli $db;
    protected string $table;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    // Obtener todos (opcional filtro active)
    public function all(bool $onlyActive = false)
    {
        $sql = "SELECT * FROM {$this->table}";

        if ($onlyActive) {
            $sql .= " WHERE active = 1";
        }

        $sql .= " ORDER BY created_at DESC";

        $result = $this->db->query($sql);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function find(int $id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function where(string $field, $value)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE {$field} = ?"
        );

        $stmt->bind_param("s", $value);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function findBySlug(string $slug)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE slug = ? LIMIT 1"
        );

        $stmt->bind_param("s", $slug);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function create(array $data)
    {
        $fields = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} ($fields) VALUES ($placeholders)"
        );

        $types = str_repeat('s', count($data));
        $stmt->bind_param($types, ...array_values($data));

        return $stmt->execute();
    }
}