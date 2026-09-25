<?php

if (!isset($orgName, $orgUrl)) {
    throw new \RuntimeException(
        'professional-service.schema.php requiere los datos de business.php'
    );
}

$professionalServiceSchema = [
    '@context' => 'https://schema.org',
    '@type'    => 'ProfessionalService',

    // Entidad local de Ikusa en Gipuzkoa
    '@id' => $orgUrl . '/#professional-service-gipuzkoa',

    'name' => $orgName,

    'url' => $canonical ?? ($orgUrl . '/es/seo-donostia'),

    'telephone' => $orgPhone ?? null,
    'email'     => $orgEmail ?? null,

    'priceRange' => '€€',

    'address' => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $orgStreetAddress ?? null,
        'addressLocality' => $orgLocality ?? null,
        'addressRegion'   => $orgRegion ?? null,
        'postalCode'      => $orgPostalCode ?? null,
        'addressCountry'  => $orgCountry ?? 'ES',
    ],

    'areaServed' => [
        [
            '@type' => 'City',
            'name'  => 'Donostia-San Sebastián',
        ],
        [
            '@type' => 'AdministrativeArea',
            'name'  => 'Gipuzkoa',
        ],
    ],

    'sameAs' => $orgSameAs ?? [],
];

$cleanSchema = function (array $data) use (&$cleanSchema) {

    foreach ($data as $key => $value) {

        if (is_array($value)) {
            $value = $cleanSchema($value);
        }

        if ($value === null || $value === '' || $value === []) {
            unset($data[$key]);
        } else {
            $data[$key] = $value;
        }
    }

    return $data;
};

$professionalServiceSchema = $cleanSchema($professionalServiceSchema);

?>
<script type="application/ld+json">
<?= json_encode(
    $professionalServiceSchema,
    JSON_UNESCAPED_SLASHES |
    JSON_UNESCAPED_UNICODE |
    JSON_PRETTY_PRINT
) ?>
</script>