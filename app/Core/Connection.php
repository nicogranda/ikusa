<?php

namespace Core;

use mysqli;

class Connection
{
    private static ?mysqli $db = null;

    public static function get(): mysqli
    {
        if (self::$db === null) {

            self::$db = new mysqli(
                $_ENV['DB_HOST'] ?? '',
                $_ENV['DB_USER'] ?? '',
                $_ENV['DB_PASS'] ?? '',
                $_ENV['DB_NAME'] ?? ''
            );

            if (self::$db->connect_error) {
                die('DB Error: ' . self::$db->connect_error);
            }

            self::$db->set_charset('utf8mb4');
        }

        return self::$db;
    }
}
