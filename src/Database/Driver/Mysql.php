<?php

namespace App\Database\Driver;

use  PDO;
use  App\Database\Connection;

final class Mysql implements Connection
{
    private static $instance = null;

    public static function getConnection()
    {
        if (self::$instance === null) {
            $connectionString =
                'mysql:host=' . (empty(getenv("MYSQL_HOST")) ? "mysql" : getenv("MYSQL_HOST")) . ';dbname=' . (empty(getenv("MYSQL_DATABASE")) ? "credit_report_service" : getenv("MYSQL_DATABASE"));

            self::$instance = new PDO(
                $connectionString,
                (empty(getenv("MYSQL_USER")) ? "root" : getenv("MYSQL_USER")),
                empty(getenv("MYSQL_PASSWORD")) ?  "password" : getenv("MYSQL_PASSWORD")
            );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}
