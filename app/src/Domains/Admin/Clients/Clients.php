<?php

namespace App\Domains\Clients;

class Clients
{
    private $mysqli;
    private string $table = 'clients';

    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function getByAlias(string $alias): ?array
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM {$this->table} WHERE alias = ?");
        $stmt->bind_param('s', $alias);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function getAllPaginated(int $limit, int $offset, string $search = ''): array
    {
        if ($search !== '') {
            $like = '%' . $search . '%';
            $stmt = $this->mysqli->prepare(
                "SELECT * FROM {$this->table}
                 WHERE id = ? OR name LIKE ? OR alias LIKE ? OR email LIKE ?
                 ORDER BY name ASC LIMIT ? OFFSET ?"
            );
            $searchId = ctype_digit($search) ? (int) $search : 0;
            $stmt->bind_param('isssii', $searchId, $like, $like, $like, $limit, $offset);
        } else {
            $stmt = $this->mysqli->prepare(
                "SELECT * FROM {$this->table} ORDER BY name ASC LIMIT ? OFFSET ?"
            );
            $stmt->bind_param('ii', $limit, $offset);
        }
    
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getTotal(string $search = ''): int
    {
        if ($search !== '') {
            $like = '%' . $search . '%';
            $stmt = $this->mysqli->prepare(
                "SELECT COUNT(*) AS total FROM {$this->table}
                 WHERE id = ? OR name LIKE ? OR alias LIKE ? OR email LIKE ?"
            );
            $searchId = ctype_digit($search) ? (int) $search : 0;
            $stmt->bind_param('isss', $searchId, $like, $like, $like);
        } else {
            $stmt = $this->mysqli->prepare("SELECT COUNT(*) AS total FROM {$this->table}");
        }
    
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return (int) ($row['total'] ?? 0);
    }

    public function existsByEmailOrTaxId(string $email, string $taxId): bool
    {
        $stmt = $this->mysqli->prepare(
            "SELECT id FROM {$this->table} WHERE email = ? OR tax_id = ? LIMIT 1"
        );
        $stmt->bind_param('ss', $email, $taxId);
        $stmt->execute();
        return (bool) $stmt->get_result()->fetch_assoc();
    }

    public function create(array $data): int
    {
        $stmt = $this->mysqli->prepare(
            "INSERT INTO {$this->table}
                (name, language, email, phone, alias, address, city, state,
                 zip_code, country, tax_id, currency, tax_note, representative,
                 business_type, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())"
        );

        $taxNote = $data['tax_note'] !== '' ? $data['tax_note'] : null;

        $stmt->bind_param(
            'sssssssssssssi',
            $data['name'],
            $data['language'],
            $data['email'],
            $data['phone'],
            $data['alias'],
            $data['address'],
            $data['city'],
            $data['state'],
            $data['zip_code'],
            $data['country'],
            $data['tax_id'],
            $data['currency'],
            $taxNote,
            $data['representative'],
            $data['business_type']
        );

        $stmt->execute();
        return $this->mysqli->insert_id;
    }

    public function updateOperationByBusinessId(int $id, int $clientId): bool
    {
        $stmt = $this->mysqli->prepare(
            "UPDATE {$this->table} SET client_id = ?, updated_at = NOW() WHERE id = ?"
        );
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('ii', $clientId, $id);
        return $stmt->execute();
    }
    
    public function update(int $id, array $data): bool
    {
        $stmt = $this->mysqli->prepare(
            "UPDATE {$this->table} SET
                name = ?, language = ?, email = ?, phone = ?, alias = ?,
                address = ?, city = ?, state = ?, zip_code = ?, country = ?,
                tax_id = ?, currency = ?, tax_note = ?, representative = ?,
                business_type = ?, updated_at = NOW()
             WHERE id = ?"
        );

        $taxNote = $data['tax_note'] !== '' ? $data['tax_note'] : null;

        $stmt->bind_param(
            'ssssssssssssssii',
            $data['name'],
            $data['language'],
            $data['email'],
            $data['phone'],
            $data['alias'],
            $data['address'],
            $data['city'],
            $data['state'],
            $data['zip_code'],
            $data['country'],
            $data['tax_id'],
            $data['currency'],
            $taxNote,
            $data['representative'],
            $data['business_type'],
            $id
        );

        return $stmt->execute();
    }

    public function existsByEmailOrTaxIdExcludingId(string $email, string $taxId, int $excludeId): bool
    {
        $stmt = $this->mysqli->prepare(
            "SELECT id FROM {$this->table} WHERE (email = ? OR tax_id = ?) AND id != ? LIMIT 1"
        );
        $stmt->bind_param('ssi', $email, $taxId, $excludeId);
        $stmt->execute();
        return (bool) $stmt->get_result()->fetch_assoc();
    }
}