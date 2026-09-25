<?php
// Requiere: $orgName, $orgUrl
// Opcional:
// $orgLegalName, $orgLogo, $orgPhone, $orgEmail,
// $orgStreetAddress, $orgLocality, $orgRegion,
// $orgPostalCode, $orgCountry, $orgSameAs

if (!isset($orgName, $orgUrl)) {
    throw new \RuntimeException(
        'organization.schema.php requiere $orgName, $orgUrl'
    );
}

$organizationSchema = [
    '@context' => 'https://schema.org',
    '@type'    => 'Organization',

    '@id' => $orgUrl . '/#organization',

    'name'      => $orgName,
    'legalName' => $orgLegalName ?? null,
    'url'       => $orgUrl,
    'logo'      => $orgLogo ?? null,

    'telephone' => $orgPhone ?? null,
    'email'     => $orgEmail ?? null,

    'address' => isset($orgStreetAddress) ? [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $orgStreetAddress,
        'addressLocality' => $orgLocality ?? null,
        'addressRegion'   => $orgRegion ?? null,
        'postalCode'      => $orgPostalCode ?? null,
        'addressCountry'  => $orgCountry ?? null,
    ] : null,

    'sameAs' => $orgSameAs ?? []
];

/*
|--------------------------------------------------------------------------
| Eliminar valores vacíos recursivamente
|--------------------------------------------------------------------------
*/

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

$organizationSchema = $cleanSchema($organizationSchema);
?>

<script type="application/ld+json">
<?= json_encode(
    $organizationSchema,
    JSON_UNESCAPED_SLASHES |
    JSON_UNESCAPED_UNICODE |
    JSON_PRETTY_PRINT
) ?>
</script>