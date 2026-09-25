<?php

/**
 * Pricing/Schema.php
 *
 * Genera datos estructurados JSON-LD a partir del mismo
 * array $pricing que utiliza Pricing.php.
 *
 * No vuelve a consultar el controlador ni duplica los planes.
 */

if (empty($pricing) || !is_array($pricing)) {
    return;
}

$schemaService = (string) ($pricing['service'] ?? '');
$schemaPlans   = $pricing['plans'] ?? [];

if (!$schemaService || !is_array($schemaPlans) || !$schemaPlans) {
    return;
}

/*
 * URL canónica de la página actual.
 *
 * Si el componente de página ya dispone de una URL canónica,
 * puedes sustituir este cálculo por esa variable.
 */
$schemaHost = $_SERVER['HTTP_HOST'] ?? 'ikusa.net';

$schemaPath = (string) parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$schemaPageUrl = 'https://'
    . $schemaHost
    . $schemaPath;

/*
 * Identificadores estables para relacionar los nodos.
 */
$schemaPageId    = $schemaPageUrl . '#webpage';
$schemaServiceId = $schemaPageUrl . '#service';
$schemaProviderId = 'https://ikusa.net/#organization';

/*
 * Servicio principal de la página.
 */
$schemaServiceName = match ($schemaService) {
    'seo'        => 'Servicios de SEO y posicionamiento web',
    'diseno-web' => 'Diseño y desarrollo web',
    default      => (string) ($pricing['title'] ?? 'Servicios profesionales'),
};

$schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'Service',
    '@id'      => $schemaServiceId,

    'name'        => $schemaServiceName,
    'description' => (string) ($pricing['intro'] ?? ''),
    'url'         => $schemaPageUrl,

    'provider' => [
        '@id' => $schemaProviderId,
    ],

    'mainEntityOfPage' => [
        '@id' => $schemaPageId,
    ],
];

/*
 * Ofertas asociadas al servicio.
 *
 * Se declara un precio numérico solamente cuando existe
 * un importe identificable en el array.
 *
 * "Gratis" se representa como 0.
 * "Presupuesto a medida" NO se convierte en precio.
 */
$schemaOffers = [];

foreach ($schemaPlans as $plan) {

    if (!is_array($plan)) {
        continue;
    }

    $planTitle = trim((string) ($plan['title'] ?? ''));

    if ($planTitle === '') {
        continue;
    }

    $planDescription = trim(
        (string) ($plan['description'] ?? '')
    );

    $planService = trim(
        (string) ($plan['service'] ?? $schemaService)
    );

    $planSlug = trim(
        (string) ($plan['plan'] ?? '')
    );

    $planUrl = 'https://ikusa.net/es/contacto?' . http_build_query([
        'servicio' => $planService,
        'plan'     => $planSlug,
    ]);

    $amount = trim((string) ($plan['amount'] ?? ''));

    /*
     * Convertimos los importes mostrados en pantalla:
     *
     * "Desde 445" -> 445
     * "1.490"     -> 1490
     * "Gratis"    -> 0
     *
     * Cualquier otro texto, como "Presupuesto a medida",
     * queda sin precio numérico.
     */
    $numericPrice = null;

    if (mb_strtolower($amount, 'UTF-8') === 'gratis') {

        $numericPrice = 0;

    } elseif (
        preg_match('/^(?:desde\s+)?([\d.,]+)$/iu', $amount, $matches)
    ) {

        $rawPrice = $matches[1];

        if (str_contains($rawPrice, ',')) {
            $rawPrice = str_replace('.', '', $rawPrice);
            $rawPrice = str_replace(',', '.', $rawPrice);
        } else {
            $rawPrice = str_replace('.', '', $rawPrice);
        }

        if (is_numeric($rawPrice)) {
            $numericPrice = (float) $rawPrice;
        }
    }

    /*
     * El tipo Service describe el plan.
     * Offer se añade solo cuando existe un precio definido.
     */
    $planSchema = [
        '@type'       => 'Service',
        'name'        => $planTitle,
        'description' => $planDescription,
        'url'         => $planUrl,
        'provider'    => [
            '@id' => $schemaProviderId,
        ],
    ];

    if ($numericPrice !== null) {

        $offer = [
            '@type'         => 'Offer',
            'url'           => $planUrl,
            'priceCurrency' => 'EUR',
            'price'         => $numericPrice,
            'itemOffered'   => $planSchema,
        ];

        /*
         * Los planes "Desde..." tienen un precio de partida.
         * No se declara que ese sea el precio final de todos
         * los proyectos.
         */
        if (
            preg_match('/^desde\s+/iu', $amount)
        ) {
            $offer['description'] = 'Precio de partida. El importe final depende del alcance del servicio.';
        }

        $schemaOffers[] = $offer;

    } else {

        /*
         * Servicios sin precio público: se describen,
         * pero no se les inventa una oferta monetaria.
         */
        $schemaOffers[] = $planSchema;
    }
}

if ($schemaOffers) {
    $schema['hasOfferCatalog'] = [
        '@type' => 'OfferCatalog',
        'name'  => 'Servicios y planes de ' . $schemaServiceName,
        'itemListElement' => $schemaOffers,
    ];
}

/*
 * JSON seguro para insertar dentro de <script>.
 */
$schemaJson = json_encode(
    $schema,
    JSON_UNESCAPED_UNICODE
    | JSON_UNESCAPED_SLASHES
    | JSON_HEX_TAG
    | JSON_HEX_AMP
    | JSON_HEX_APOS
    | JSON_HEX_QUOT
);

if ($schemaJson !== false):
?>
<script type="application/ld+json"><?= $schemaJson ?></script>
<?php endif; ?>