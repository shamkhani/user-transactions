<?php

namespace App\Database;

use  App\Database\Driver\Mysql;

final class DatabaseFactory
{

    /**
     * Get Database Connection Provider
     * 
     */
    public function getProvider($dbName): Connection
    {
        switch ($dbName) {
            case "mysql":
                return new Mysql();
        }
    }
}
