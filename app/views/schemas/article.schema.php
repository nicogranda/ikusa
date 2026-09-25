<?php
// Requiere: $articleTitle, $articleDescription, $articleImage, $articleUrl, $articleDatePublished,
//           $publisherName, $publisherLogo
// Opcional: $articleDateModified, $articleAuthor
if (!isset($articleTitle, $articleDescription, $articleImage, $articleUrl, $articleDatePublished, $publisherName, $publisherLogo)) {
    throw new \RuntimeException('article.schema.php requiere datos del artículo y del publisher');
}

$articleSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'BlogPosting',
    'headline' => $articleTitle,
    'description' => $articleDescription,
    'image' => $articleImage,
    'url' => $articleUrl,
    'datePublished' => $articleDatePublished,
    'dateModified' => $articleDateModified ?? $articleDatePublished,
    'author' => ['@type' => 'Organization', 'name' => $articleAuthor ?? $publisherName],
    'publisher' => [
        '@type' => 'Organization',
        'name' => $publisherName,
        'logo' => ['@type' => 'ImageObject', 'url' => $publisherLogo]
    ]
];
?>
<script type="application/ld+json"><?= json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
