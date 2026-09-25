<?php
// Requiere: $collectionName, $collectionUrl, $items (array ['name'=>..,'url'=>..])
if (!isset($collectionName, $collectionUrl, $items)) {
    throw new \RuntimeException('collection.schema.php requiere $collectionName, $collectionUrl, $items');
}

$collectionSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => $collectionName,
    'url' => $collectionUrl,
    'mainEntity' => [
        '@type' => 'ItemList',
        'itemListElement' => array_map(fn($item, $i) => [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $item['name'],
            'url' => $item['url']
        ], $items, array_keys($items))
    ]
];
?>
<script type="application/ld+json"><?= json_encode($collectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
