<?php
// app/Domains/Pages/PageTranslation.php
namespace App\Domains\Pages;

class PageTranslation
{
    private \mysqli $db;

    public function __construct(\mysqli $db)
    {
        $this->db = $db;
    }

    public function create(array $data): int
    {
        $faqsJson = isset($data['faqs']) ? json_encode($data['faqs'], JSON_UNESCAPED_UNICODE) : null;

        $stmt = $this->db->prepare(
            "INSERT INTO page_translations
                (page_id, language, slug, title, meta_description, keywords,
                 og_title, og_description, og_image,
                 twitter_title, twitter_description, twitter_image,
                 canonical_url, content, faqs)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            'issssssssssssss',
            $data['page_id'],
            $data['language'],
            $data['slug'],
            $data['title'],
            $data['meta_description'],
            $data['keywords'],
            $data['og_title'],
            $data['og_description'],
            $data['og_image'],
            $data['twitter_title'],
            $data['twitter_description'],
            $data['twitter_image'],
            $data['canonical_url'],
            $data['content'],
            $faqsJson
        );

        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }

    public function findBySlug(string $language, string $slug): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT pt.*, p.reference
             FROM page_translations pt
             JOIN pages p ON p.id = pt.page_id
             WHERE pt.language = ? AND pt.slug = ? LIMIT 1"
        );
        $stmt->bind_param('ss', $language, $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
    
        if ($row && $row['faqs']) {
            $row['faqs'] = json_decode($row['faqs'], true);
        }
    
        return $row ?: null;
    }

    public function findByPageId(int $pageId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM page_translations WHERE page_id = ?");
        $stmt->bind_param('i', $pageId);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        foreach ($rows as &$row) {
            if ($row['faqs']) {
                $row['faqs'] = json_decode($row['faqs'], true);
            }
        }

        return $rows;
    }

    public function update(int $id, array $data): bool
    {
        $faqsJson = isset($data['faqs']) ? json_encode($data['faqs'], JSON_UNESCAPED_UNICODE) : null;

        $stmt = $this->db->prepare(
            "UPDATE page_translations SET
                slug = ?, title = ?, meta_description = ?, keywords = ?,
                og_title = ?, og_description = ?, og_image = ?,
                twitter_title = ?, twitter_description = ?, twitter_image = ?,
                canonical_url = ?, content = ?, faqs = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            'sssssssssssssi',
            $data['slug'],
            $data['title'],
            $data['meta_description'],
            $data['keywords'],
            $data['og_title'],
            $data['og_description'],
            $data['og_image'],
            $data['twitter_title'],
            $data['twitter_description'],
            $data['twitter_image'],
            $data['canonical_url'],
            $data['content'],
            $faqsJson,
            $id
        );

        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    /**
     * Devuelve el canonical: usa canonical_url si está seteado,
     * si no lo calcula a partir de language + slug.
     */
    public function resolveCanonical(array $translation, string $baseUrl = 'https://ikusa.net'): string
    {
        if (!empty($translation['canonical_url'])) {
            return $translation['canonical_url'];
        }
        return rtrim($baseUrl, '/') . '/' . $translation['language'] . '/' . $translation['slug'];
    }
}
