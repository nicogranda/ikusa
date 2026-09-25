<?php
// Requiere: $businessName, $businessUrl, $businessPhone, $streetAddress, $locality, $region, $country
// Opcional: $businessType (default 'LocalBusiness'), $latitude, $longitude, $priceRange, $openingHours (array)
if (!isset($businessName, $businessUrl, $businessPhone, $streetAddress, $locality, $region, $country)) {
    throw new \RuntimeException('local-business.schema.php requiere datos básicos del negocio');
}

$localBusinessSchema = [
    '@context' => 'https://schema.org',
    '@type' => $businessType ?? 'LocalBusiness',
    'name' => $businessName,
    'url' => $businessUrl,
    'telephone' => $businessPhone,
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $streetAddress,
        'addressLocality' => $locality,
        'addressRegion' => $region,
        'addressCountry' => $country,
    ],
    'geo' => isset($latitude, $longitude) ? [
        '@type' => 'GeoCoordinates',
        'latitude' => $latitude,
        'longitude' => $longitude,
    ] : null,
    'priceRange' => $priceRange ?? null,
    'openingHoursSpecification' => $openingHours ?? null,
];
?>
<script type="application/ld+json"><?= json_encode(array_filter($localBusinessSchema), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
