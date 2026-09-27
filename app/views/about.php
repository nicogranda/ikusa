<?php
// Compatibilidad con rutas antiguas que todavía incluyen app/views/about.php.
require_once __DIR__ . '/../src/Domains/About/AboutModel.php';
require_once __DIR__ . '/../src/Domains/About/AboutController.php';
(new \App\Domains\About\AboutController())->show();
