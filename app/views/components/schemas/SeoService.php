<?php
/**
 * Schema: Service — SEO Donostia
 *
 * Variables disponibles:
 * $translation
 * $canonical
 * $language
 * $orgName
 * $orgUrl
 */

$serviceDescription = 'Servicio de posicionamiento web y SEO en Donostia-San Sebastián para empresas que quieren aumentar su visibilidad en Google, mejorar su posicionamiento orgánico y captar clientes mediante estrategias de SEO técnico, SEO local, contenidos y optimización web.';

$serviceSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Service',

    'name' => 'Posicionamiento web y SEO en Donostia-San Sebastián',

    'description' => $serviceDescription,

    'url' => $canonical,

    'serviceType' => 'Posicionamiento web y SEO',

    'provider' => [
        '@type' => 'Organization',
        'name' => $orgName,
        'url' => $orgUrl,
    ],

    'areaServed' => [
        [
            '@type' => 'City',
            'name' => 'Donostia-San Sebastián',
        ],
        [
            '@type' => 'AdministrativeArea',
            'name' => 'Gipuzkoa',
        ],
    ],
];
?>

<script type="application/ld+json">
<?= json_encode(
    $serviceSchema,
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES |
    JSON_PRETTY_PRINT
); ?>
</script>