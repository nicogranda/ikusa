<?php
/**
 * Service Schema Component
 * Requiere: $translation (array), $canonical (string)
 * Opcional: $serviceOffers (array) — [['name' => ..., 'price' => ..., 'period' => 'P1M'], ...]
 */
if (empty($translation) || empty($canonical)) {
    return;
}

$serviceSchema = [
    "@context" => "https://schema.org",
    "@type" => "Service",
    "serviceType" => $translation['h1'] ?? $translation['title'],
    "name" => $translation['title'],
    "description" => $translation['meta_description'] ?? $translation['excerpt'] ?? '',
    "provider" => [
        "@id" => "https://ikusa.net/#organization",
    ],
    "areaServed" => [
        ["@type" => "City", "name" => "Donostia-San Sebastián"],
        ["@type" => "AdministrativeArea", "name" => "Gipuzkoa"],
    ],
    "url" => $canonical,
];

if (!empty($serviceOffers) && is_array($serviceOffers)) {
    $serviceSchema['offers'] = array_map(function ($offer) {
        return [
            "@type" => "Offer",
            "name" => $offer['name'],
            "price" => (string) $offer['price'],
            "priceCurrency" => "EUR",
            "priceSpecification" => [
                "@type" => "UnitPriceSpecification",
                "price" => (string) $offer['price'],
                "priceCurrency" => "EUR",
                "billingDuration" => $offer['period'] ?? "P1M",
            ],
        ];
    }, $serviceOffers);
}
?>
<script type="application/ld+json">
<?= json_encode($serviceSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>
</script>
