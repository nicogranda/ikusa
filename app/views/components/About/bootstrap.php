<?php
// Incluido desde Pages/Views/Show.php; no produce marcado por sí mismo.
require_once __DIR__ . '/../../../src/Domains/About/AboutController.php';

global $mysqli;
if (!($mysqli instanceof \mysqli)) {
    throw new \RuntimeException('Falta la conexión MySQLi para los componentes de About.');
}

if (!function_exists('render_about_section')) {
    function render_about_section(string $name, string $language, \mysqli $db): void
    {
        static $cssLoaded = false;
        if (!$cssLoaded) {
            $css = __DIR__ . '/../../../src/Domains/About/Assets/css/style.css';
            if (is_file($css)) {
                echo '<style>';
                readfile($css);
                echo '</style>';
            }
            $cssLoaded = true;
        }
        (new \App\Domains\About\AboutController($db))->render($name, $language);
    }
}
