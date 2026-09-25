<?php

namespace App\Domains\Messaging;

class MessagingRepository
{
    protected \mysqli $mysqli;

    public function __construct(\mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function findSupplierByAlias(string $alias): ?array
    {
        $stmt = $this->mysqli->prepare("
            SELECT id, alias, name, email
            FROM suppliers
            WHERE alias = ?
            LIMIT 1
        ");

        $stmt->bind_param('s', $alias);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result ?: null;
    }

    public function findClientByAlias(string $alias): ?array
    {
        $stmt = $this->mysqli->prepare("
            SELECT id, alias, name, email, representative
            FROM clients
            WHERE alias = ?
            LIMIT 1
        ");

        $stmt->bind_param('s', $alias);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result ?: null;
    }
}