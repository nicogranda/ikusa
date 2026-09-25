<?php
// Requiere: $siteName, $siteUrl
// Opcional: $siteSearchUrlTemplate (ej: 'https://ikusa.net/search?q={search_term_string}')
if (!isset($siteName, $siteUrl)) {
    throw new \RuntimeException('website.schema.php requiere $siteName, $siteUrl');
}

$websiteSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => $siteName,
    'url' => $siteUrl,
];

if (!empty($siteSearchUrlTemplate)) {
    $websiteSchema['potentialAction'] = [
        '@type' => 'SearchAction',
        'target' => [
            '@type' => 'EntryPoint',
            'urlTemplate' => $siteSearchUrlTemplate
        ],
        'query-input' => 'required name=search_term_string'
    ];
}
?>
<script type="application/ld+json"><?= json_encode($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
