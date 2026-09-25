<?php
/**
 * Breadcrumb Component
 * Requiere:
 * $translation, $canonical, $language, $slug, $orgUrl
 */

if (empty($translation) || empty($canonical) || ($slug ?? '') === 'inicio') {
    return;
}

$homeLabel = match ($language) {
    'en' => 'Home',
    'eu' => 'Hasiera',
    default => 'Inicio',
};

$currentLabel = $translation['h1']
    ?: ($translation['title'] ?? '');

$homeUrl = rtrim($orgUrl, '/') . '/' . $language;

$breadcrumbSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => $homeLabel,
            'item' => $homeUrl,
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => $currentLabel,
            'item' => $canonical,
        ],
    ],
];
?>

<nav class="breadcrumb" aria-label="Breadcrumb">
    <a href="<?= htmlspecialchars($homeUrl) ?>">
        <?= htmlspecialchars($homeLabel) ?>
    </a>

    <span class="breadcrumb__separator">›</span>

    <span aria-current="page">
        <?= htmlspecialchars($currentLabel) ?>
    </span>
</nav>

<script type="application/ld+json">
<?= json_encode(
    $breadcrumbSchema,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
); ?>
</script>

<style>
    .breadcrumb {
        padding: 5px 0 0 20px;
    }
</style>