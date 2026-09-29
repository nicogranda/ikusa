<?php
// app/views/components/team.php
// Punto de entrada para page_translations.components = 'team.php'.
require_once __DIR__ . '/../../src/Domains/Components/ComponentModel.php';
require_once __DIR__ . '/../../src/Domains/Components/ComponentController.php';

global $mysqli;

$cssFile = __DIR__ . '/../../src/Domains/Components/Assets/css/style.css';
if (is_file($cssFile)) {
    echo '<style>';
    readfile($cssFile);
    echo '</style>';
}

(new \App\Domains\Components\ComponentController($mysqli))
    ->render('team', $language ?? 'es');
