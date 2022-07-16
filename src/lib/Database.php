<?php

declare(strict_types=1);

namespace App\Lib;

use \PDO;

class Database
{
    static string $host = "localhost";
    static string $name = "testdb";
    static string $user = "root";
    static string $password = "";  

    public static function connect(): PDO
    {
        $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$name . ";charset=utf8";

        return new PDO($dsn, self::$user, self::$password);
    }

}