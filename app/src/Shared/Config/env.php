<?php
declare(strict_types=1);

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Posibles ubicaciones del .env
$paths = [
    dirname(__DIR__, 2) . '/public_html', // si está en public_html
    dirname(__DIR__, 2),                  // si está en la raíz del proyecto
];

$loaded = false;
foreach ($paths as $path) {
    if (file_exists($path . '/.env')) {
        $dotenv = Dotenv::createImmutable($path);
        $dotenv->safeLoad();
        $loaded = true;
        break;
    }
}

if (!$loaded) {
    throw new \RuntimeException('.env no encontrado en las rutas esperadas.');
}