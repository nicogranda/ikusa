<?php
namespace Domains\Project;

use Shared\Model;

class Project extends Model {
    protected $table = 'projects';

    // Filtrar por herramienta
    public function filterByTool($tool) {
        $sql = "SELECT * FROM {$this->table} WHERE FIND_IN_SET(?, tools) AND active = 1 ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $tool);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    }

    // Generar slug automáticamente a partir del título
    public static function generateSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return rtrim($slug, '-');
    }
}