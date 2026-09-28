<?php
// Identificador para page_translations.components: Team/team.php
require_once __DIR__ . '/../../../src/Domains/Components/ComponentModel.php';
require_once __DIR__ . '/../../../src/Domains/Components/ComponentController.php';

global $mysqli;
if (!($mysqli instanceof \mysqli)) {
    throw new \RuntimeException('Se necesita la conexión MySQLi de config/connection.php.');
}

$cssUrl = function_exists('asset_url')
    ? asset_url('css/components.css')
    : '/assets/css/components.css';
?>
<link rel="stylesheet" href="<?= htmlspecialchars($cssUrl, ENT_QUOTES, 'UTF-8') ?>">
<?php
(new \App\Domains\Components\ComponentController($mysqli))
    ->render('team', $language ?? 'es');
