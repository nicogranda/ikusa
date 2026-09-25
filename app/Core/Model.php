<?php

namespace Core;

use mysqli;
use Core\Connection;

abstract class Model
{
    protected mysqli $db;
    protected string $table;
    protected string $primaryKey = 'id';
    protected string $lang = 'es';

    public function __construct(string $lang = 'es')
    {
        $this->db   = Connection::get();
        $this->lang = $lang;
    }

    // ==================================================
    // READ
    // ==================================================

    public function all(bool $onlyActive = false): array
    {
        $sql = "SELECT * FROM {$this->table}";
        if ($onlyActive) {
            $sql .= " WHERE active = 1";
        }
        $sql .= " ORDER BY created_at DESC";

        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Busca por PK.
     * $model->getById(5)
     */
    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1"
        );
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    /**
     * Busca por cualquier columna.
     * $model->getBy('slug', 'desarrollo-web')        → un registro
     * $model->getBy('status', 'active', false)       → array
     */
    public function getBy(string $column, mixed $value, bool $single = true): array|null
    {
        $type = is_int($value) ? 'i' : 's';
        $sql  = "SELECT * FROM {$this->table} WHERE {$column} = ?";
        if ($single) {
            $sql .= " LIMIT 1";
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($type, $value);
        $stmt->execute();
        $result = $stmt->get_result();

        return $single
            ? ($result->fetch_assoc() ?: null)
            : $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Múltiples condiciones AND.
     * $model->getWhere(['lang' => 'es', 'active' => '1'])
     * $model->getWhere(['lang' => 'es'], ['order' => 'title ASC', 'limit' => 10])
     */
    public function getWhere(array $conditions, array $options = []): array
    {
        if (empty($conditions)) {
            return $this->all();
        }

        $clauses = [];
        $types   = '';
        $values  = [];

        foreach ($conditions as $field => $value) {
            $clauses[] = "{$field} = ?";
            $types    .= is_int($value) ? 'i' : 's';
            $values[]  = $value;
        }

        $sql  = "SELECT * FROM {$this->table} WHERE " . implode(' AND ', $clauses);
        $sql .= " ORDER BY " . ($options['order'] ?? 'created_at DESC');

        if (!empty($options['limit'])) {
            $sql .= " LIMIT " . (int) $options['limit'];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // ==================================================
    // CREATE
    // ==================================================

    /**
     * Devuelve el ID insertado o false.
     * $model->create(['title' => 'Hola', 'lang' => 'es'])
     */
    public function create(array $data): int|false
    {
        $now = date('Y-m-d H:i:s');
        $data['created_at'] = $now;
        $data['updated_at'] = $now;

        $fields       = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $stmt = $this->db->prepare(
            "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})"
        );
        $stmt->bind_param(str_repeat('s', count($data)), ...array_values($data));
        return $stmt->execute() ? (int) $this->db->insert_id : false;
    }

    // ==================================================
    // UPDATE
    // ==================================================

    /**
     * $model->update(5, ['title' => 'Nuevo título'])
     */
    public function update(int $id, array $data): bool
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $sets   = implode(', ', array_map(fn($f) => "{$f} = ?", array_keys($data)));
        $types  = str_repeat('s', count($data)) . 'i';
        $values = [...array_values($data), $id];

        $stmt = $this->db->prepare(
            "UPDATE {$this->table} SET {$sets} WHERE {$this->primaryKey} = ?"
        );
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }

    // ==================================================
    // DELETE
    // ==================================================

    /**
     * Hard delete por ID.
     * $model->delete(5)
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?"
        );
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}