<?php
// app/Domains/Irs/IrsFilingRepository.php
namespace App\Domains\Irs;

use mysqli;

class IrsFilingRepository
{
    private mysqli $db;
    public function __construct(mysqli $db) { $this->db = $db; }

    public function fetchOne(string $sql, string $types, array $params): ?array
    {
        $stmt = $this->db->prepare($sql);
        if ($types) $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $r ?: null;
    }

    public function fetchAll(string $sql, string $types = '', array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        if ($types) $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $r = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $r;
    }

    // Insert/update genérico: arma el SQL desde las keys del array (evita bind_param manual gigante)
    public function insert(string $table, array $data): int
    {
        $cols = array_keys($data);
        $placeholders = implode(',', array_fill(0, count($cols), '?'));
        $sql = "INSERT INTO `$table` (`" . implode('`,`', $cols) . "`) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $types = str_repeat('s', count($data)); // mysqli castea strings numéricos sin problema
        $stmt->bind_param($types, ...array_values($data));
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    public function update(string $table, int $id, array $data, string $idCol = 'id'): void
    {
        $sets = implode(',', array_map(fn($c) => "`$c` = ?", array_keys($data)));
        $sql = "UPDATE `$table` SET $sets WHERE `$idCol` = ?";
        $stmt = $this->db->prepare($sql);
        $types = str_repeat('s', count($data)) . 'i';
        $stmt->bind_param($types, ...array_values($data), ...[$id]);
        $stmt->execute();
        $stmt->close();
    }

    public function updateByFilingId(string $table, int $filingId, array $data): void
    {
        $this->update($table, $filingId, $data, 'filing_id');
    }
}