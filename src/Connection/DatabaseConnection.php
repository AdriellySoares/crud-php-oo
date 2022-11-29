<?php

declare(strict_types = 1);

namespace App\Connection;
use PDO;

class DatabaseConnection
{
    public static function abrirConexao(): PDO
    {
        $db = DB_NAME;
        return new PDO("mysql:host=localhost; dbname={$db}", DB_USER, DB_PASSWORD);
    }
}

