<?php
require_once __DIR__ . '/bootstrap.php';
render_about_section('about-places', $language ?? 'es', $mysqli);
