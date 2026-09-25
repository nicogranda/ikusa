<?php
// Requiere: $serviceType, $serviceName, $serviceDescription, $pageUrl, $providerName, $providerUrl
// Opcional: $offerArticles (array ['title'=>..,'content'=>..]), $areaServedName
if (!isset($serviceType, $serviceName, $serviceDescription, $pageUrl, $providerName, $providerUrl)) {
    throw new \RuntimeException('service.schema.php requiere $serviceType, $serviceName, $serviceDescription, $pageUrl, $providerName, $providerUrl');
}

$serviceSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Service',
    'serviceType' => $serviceType,
    'name' => $serviceName,
    'description' => $serviceDescription,
    'url' => $pageUrl,
    'provider' => [
        '@type' => 'Organization',
        'name' => $providerName,
        'url' => $providerUrl
    ],
    'areaServed' => isset($areaServedName) ? ['@type' => 'Country', 'name' => $areaServedName] : null
];

if (!empty($offerArticles)) {
    $serviceSchema['hasOfferCatalog'] = [
        '@type' => 'OfferCatalog',
        'name' => $serviceName,
        'itemListElement' => array_map(fn($a) => [
            '@type' => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $a['title'], 'description' => $a['content']]
        ], $offerArticles)
    ];
}
?>
<script type="application/ld+json"><?= json_encode(array_filter($serviceSchema), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
