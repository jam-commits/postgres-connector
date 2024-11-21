<?php

namespace JamCommits\PostgresConnector;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection === null) {
            $dbHost = getenv('POSTGRES_HOST') ?: 'postgres';
            $dbPort = getenv('POSTGRES_PORT') ?: '5432';
            $dbName = getenv('POSTGRES_DB') ?: 'mydatabase';
            $dbUser = getenv('POSTGRES_USER') ?: 'myuser';
            $dbPassword = getenv('POSTGRES_PASSWORD') ?: 'mypassword';

            $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";

            try {
                self::$connection = new PDO($dsn, $dbUser, $dbPassword, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
                echo "Connexion réussie à la base de données PostgreSQL.\n";
            } catch (PDOException $e) {
                throw new \RuntimeException("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}

