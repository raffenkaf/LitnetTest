<?php

namespace database;

use PDO;

class PDOWrapper
{
    private static PDO $pdo;

    public static function getPDO(): PDO
    {
        if (self::isPDOActive()) {
            return self::$pdo;
        }

        $config = include('dbconfig.php');

        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";

        self::$pdo = new PDO($dsn, $config['username'], $config['password']);

        return self::$pdo;
    }

    private static function isPDOActive(): bool
    {
        if (!isset(self::$pdo)) {
            return false;
        }

        try {
            $stm = self::$pdo->query("SELECT VERSION()");
            $stm->fetch();
        } catch (\Exception $exception) {
            return false;
        }

        return true;
    }
}