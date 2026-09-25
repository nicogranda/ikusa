<?php

namespace App\Domains\Services;

use Core\Model;

class Service extends Model
{
    protected string $table = 'services';

    public function __construct(string $lang = 'es')
    {
        parent::__construct($lang);
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT s.*, st.name, st.excerpt, st.slug
            FROM {$this->table} s
            JOIN service_translations st ON st.service_id = s.id
            WHERE s.status = 1
              AND st.language = ?
            ORDER BY s.order ASC
        ");
        $stmt->bind_param('s', $this->lang);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBySlug(string $slug): ?array
    {
        $stmt = $this->db->prepare("
            SELECT s.*, st.name, st.excerpt, st.slug, st.content,
                   st.meta_title, st.meta_description
            FROM {$this->table} s
            JOIN service_translations st ON st.service_id = s.id
            WHERE st.slug    = ?
              AND st.language = ?
            LIMIT 1
        ");
        $stmt->bind_param('ss', $slug, $this->lang);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    public function getRelated(string $slug): array
    {
        $stmt = $this->db->prepare("
            SELECT s.*, st.name, st.excerpt, st.slug
            FROM {$this->table} s
            JOIN service_translations st ON st.service_id = s.id
            WHERE s.status   = 1
              AND st.language = ?
              AND st.slug    != ?
            ORDER BY s.order ASC
        ");
        $stmt->bind_param('ss', $this->lang, $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
