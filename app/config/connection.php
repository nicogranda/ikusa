<?php
// app/config/connection.php
require_once __DIR__ . '/env.php';

if (!defined('DB_HOST')) {
    $db_host = $_ENV['DB_HOST'] ?? 'localhost';
    $db_user = $_ENV['DB_USER'] ?? '';
    $db_password = $_ENV['DB_PASS'] ?? '';
    $db_db = $_ENV['DB_NAME'] ?? '';

    define('DB_HOST',  $db_host);
    define('DB_USER', $db_user);
    define('DB_PASS', $db_password);
    define('DB_NAME',  $db_db);
}

if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    $mysqli = @new mysqli(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME
    );

    $mysqli->set_charset("utf8mb4");

    if ($mysqli->connect_error) {
        echo 'Errno: '.$mysqli->connect_errno;
        echo '<br>';
        echo 'Error: '.$mysqli->connect_error;
        exit();
    }
}