<?php
// Requiere: $breadcrumbs (array ordenado: [['name'=>'Home','url'=>'https://...'], ...])
// Nota: 'url' debe ser absoluta (incluye el dominio) para ser reutilizable entre proyectos
if (empty($breadcrumbs)) return;

$breadcrumbSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => array_map(fn($item, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $item['name'],
        'item' => $item['url']
    ], $breadcrumbs, array_keys($breadcrumbs))
];
?>
<script type="application/ld+json"><?= json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
