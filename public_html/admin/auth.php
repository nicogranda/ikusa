<?php
if (empty($_SESSION['user_id']) || ($_SESSION['user']['role'] ?? null) !== 'admin') {
    $script = $_SERVER['SCRIPT_NAME'] ?? '/admin/index.php';
    $prefix = preg_replace('~(?:/public_html)?/admin/index\\.php$~', '', $script);
    header('Location: ' . rtrim($prefix, '/') . '/admin');
    exit;
}
