<?php
declare(strict_types=1);

namespace App\Domains\Components;

use RuntimeException;

require_once __DIR__ . '/../../Shared/Model.php';

final class ComponentModel extends \Src\Shared\Model
{
    protected string $table = 'components';

    /** @return array<int, array<string, mixed>> */
    public function findByNameAndLanguage(string $name, string $language): array
    {
        $sql = <<<'SQL'
SELECT c.id, c.name, c.type, c.image, c.sort_order,
       t.title, t.subtitle, t.text, t.image_alt
FROM components AS c
INNER JOIN component_translations AS t ON t.component_id = c.id
WHERE c.name = ? AND c.status = 'published' AND t.language = ?
ORDER BY c.sort_order ASC, c.id ASC
SQL;
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException('No se pudo preparar la consulta de componentes.');
        }
        try {
            $stmt->bind_param('ss', $name, $language);
            if (!$stmt->execute()) {
                throw new RuntimeException('No se pudieron consultar los componentes.');
            }
            $result = $stmt->get_result();
            if (!$result) {
                throw new RuntimeException('No se pudieron leer los componentes.');
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        } finally {
            $stmt->close();
        }
    }
}
