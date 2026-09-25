<?php

namespace Src\Shared\Config;

use mysqli;
use Exception;

class Connection
{
    private static ?mysqli $instance = null;

    public static function get(): mysqli
    {
        if (self::$instance === null) {

            $db_host = $_ENV['DB_HOST'] ?? 'localhost';
            $db_user = $_ENV['DB_USER'] ?? '';
            $db_password = $_ENV['DB_PASS'] ?? '';
            $db_name = $_ENV['DB_NAME'] ?? '';

            $mysqli = new mysqli(
                $db_host,
                $db_user,
                $db_password,
                $db_name
            );

            if ($mysqli->connect_error) {
                throw new Exception(
                    'DB Error (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error
                );
            }

            $mysqli->set_charset("utf8mb4");

            self::$instance = $mysqli;
        }

        return self::$instance;
    }
}