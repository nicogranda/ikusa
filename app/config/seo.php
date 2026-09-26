<?php
declare(strict_types=1);

// Datos SEO antiguos como respaldo de page_translations.
// Este archivo no imprime HTML: head.php genera las etiquetas.
$seoData = [];
$seoPage = in_array($page, ['services', 'blog', 'lead'], true)
    && !empty($_GET['action'])
    ? (string) $_GET['action']
    : (string) $page;

if (in_array($seoPage, ['inicio', 'home'], true)) {
    $seoPage = 'home';
}

try {
    $stmt = $mysqli->prepare(
        'SELECT title, description, keywords, og_title, og_description, og_image,
                twitter_title, twitter_description, twitter_image, `schema`
         FROM seo WHERE page = ? AND language = ? LIMIT 1'
    );
    $stmt->bind_param('ss', $seoPage, $lang);
    $stmt->execute();
    $seoData = $stmt->get_result()->fetch_assoc() ?: [];
    $stmt->close();
} catch (\mysqli_sql_exception $exception) {
    error_log('SEO lookup failed: ' . $exception->getMessage());
}
