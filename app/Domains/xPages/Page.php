<?php
// app/Domains/Pages/Page.php
namespace App\Domains\Pages;

class Page
{
    private \mysqli $db;

    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function create(string $type = 'landing', string $status = 'draft'): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO pages (type, status) VALUES (?, ?)"
        );
        $stmt->bind_param('ss', $type, $status);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM pages WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public function all(?string $type = null): array
    {
        if ($type !== null) {
            $stmt = $this->db->prepare("SELECT * FROM pages WHERE type = ? ORDER BY created_at DESC");
            $stmt->bind_param('s', $type);
        } else {
            $stmt = $this->db->prepare("SELECT * FROM pages ORDER BY created_at DESC");
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE pages SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $status, $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public function delete(int $id): bool
    {
        // Hard delete — page_translations se borran en cascada (FK ON DELETE CASCADE)
        $stmt = $this->db->prepare("DELETE FROM pages WHERE id = ?");
        $stmt->bind_param('i', $id);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
    
    public function getChildren(int $parentId, string $lang): array
    {
        $sql = "
            SELECT
                p.id,
                p.type,
                p.reference,
                p.status,
                pt.slug,
                pt.title,
                pt.h1,
                pt.excerpt,
                pt.hero_image,
                pt.hero_image_alt
            FROM pages p
            INNER JOIN page_translations pt
                ON pt.page_id = p.id
            WHERE p.parent_id = ?
              AND p.status = 'published'
              AND pt.language = ?
            ORDER BY p.id ASC
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('is', $parentId, $lang);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
    
        $stmt->close();
    
        return $rows;
    }
}
