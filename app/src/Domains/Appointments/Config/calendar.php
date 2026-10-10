<?php

// La configuración local tiene prioridad; el .env sigue siendo compatible.
$config = [
    'calendar_id' => $_ENV['GOOGLE_CALENDAR_ID'] ?? '',
    'credentials_path' => $_ENV['GOOGLE_CALENDAR_CREDENTIALS'] ?? '',
];

$localPath = __DIR__ . '/calendar.local.php';
if (is_file($localPath)) {
    $local = require $localPath;
    if (!is_array($local)) {
        throw new \RuntimeException('calendar.local.php debe devolver un array de configuración.');
    }
    foreach (['calendar_id', 'credentials_path'] as $key) {
        if (isset($local[$key]) && trim((string) $local[$key]) !== '') {
            $config[$key] = $local[$key];
        }
    }
}

if (trim((string) $config['credentials_path']) === '') {
    $config['credentials_path'] = __DIR__ . '/credentials.json';
} elseif (!str_starts_with((string) $config['credentials_path'], '/')) {
    $config['credentials_path'] = __DIR__ . '/' . $config['credentials_path'];
}

return $config;
