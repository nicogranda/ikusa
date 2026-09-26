<?php
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
if ($routePrefix !== '' && ($requestPath === $routePrefix || str_starts_with($requestPath, $routePrefix . '/'))) {
    $requestPath = substr($requestPath, strlen($routePrefix)) ?: '/';
}
if ($requestPath === '/public_html' || str_starts_with($requestPath, '/public_html/')) {
    $requestPath = substr($requestPath, strlen('/public_html')) ?: '/';
}
if ($requestPath === '/' || $requestPath === '/index.php') {
    $requestPath = '/' . ($lang ?? 'es');
}
$currentUrl = rtrim((string) ($config['url'] ?? ''), '/') . $requestPath;
$route = trim($requestPath, '/');

$site = [
    'name'        => $config['site_name'],
    'url'         => $config['url'],
    'logo'        => $config['url'] . '/assets/img/logo.png',
    'description' => $config['description'],
    'language'    => $config['lang'] ?? 'es',
    'social'      => $config['social'] ?? []
];

function schemaOrganization($site)
{
    return [
        '@type'       => 'Organization',
        '@id'         => $site['url'] . '/#organization',
        'name'        => $site['name'],
        'url'         => $site['url'] . '/',
        'logo'        => ['@type' => 'ImageObject', 'url' => $site['logo']],
        'description' => $site['description'],
        'sameAs'      => $site['social']
    ];
}
function schemaWebsite($site)
{
    return [
        '@type'      => 'WebSite',
        '@id'        => $site['url'] . '/#website',
        'url'        => $site['url'] . '/',
        'name'       => $site['name'],
        'publisher'  => ['@id' => $site['url'] . '/#organization'],
        'inLanguage' => $site['language']
    ];
}
function schemaWebPage($site, $seoData, $currentUrl)
{
    return [
        '@type'       => 'WebPage',
        'url'         => $currentUrl,
        'name'        => $seoData['title'],
        'description' => $seoData['description'],
        'isPartOf'    => ['@id' => $site['url'] . '/#website'],
        'about'       => ['@id' => $site['url'] . '/#organization'],
        'inLanguage'  => $site['language']
    ];
}
function schemaService($site, $serviceName, $serviceUrl)
{
    return [
        '@type'       => 'Service',
        'serviceType' => $serviceName,
        'name'        => $serviceName,
        'provider'    => ['@type' => 'Organization', 'name' => $site['name'], 'url' => $site['url']],
        'url'         => $serviceUrl
    ];
}

// Páginas migradas al sistema de componentes — no usan el schema de la BD
$migratedSlugs = ["seo-donostia"];
$routeSlug = basename($route);
if (in_array($routeSlug, $migratedSlugs, true)) {
    $schema = "";
    return;
}
// Si la DB tiene schema para esta página, úsalo y termina
if (!empty($seoData['schema'])) {
    $schema = $seoData['schema'];
    return;
}

// Si no, genera el genérico por ruta
$graph = [];
switch ($route) {
    case '':
    case 'home':
        $graph[] = schemaOrganization($site);
        $graph[] = schemaWebsite($site);
        $graph[] = schemaWebPage($site, $seoData, $currentUrl);
    break;
    case 'seo':
        $graph[] = schemaService($site, 'SEO', $site['url'] . '/seo');
    break;
    case 'web-design':
        $graph[] = schemaService($site, 'Diseño Web', $site['url'] . '/web-design');
    break;
    case 'contact':
        $graph[] = ['@type' => 'ContactPage', 'name' => $seoData['title'], 'url' => $currentUrl];
    break;
    default:
        $graph[] = schemaWebPage($site, $seoData, $currentUrl);
    break;
}

$schema = json_encode(
    ['@context' => 'https://schema.org', '@graph' => $graph],
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
);
