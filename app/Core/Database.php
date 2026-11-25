<?php

namespace App\Core;

class Database
{
    protected static ?\PDO $pdo = null;

    public static function getConnection(): \PDO
    {
        if (static::$pdo === null) {
            $host = Config::get('database.host', '127.0.0.1');
            $port = Config::get('database.port', '3306');
            $dbname = Config::get('database.database', 'dynamice_academy_db');
            $charset = Config::get('database.charset', 'utf8mb4');
            $username = Config::get('database.username', 'root');
            $password = Config::get('database.password', '');
            $options = Config::get('database.options', [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

            try {
                static::$pdo = new \PDO($dsn, $username, $password, $options);
            } catch (\PDOException $e) {
                Logger::error('Database Connection Error: ' . $e->getMessage());
                throw new \RuntimeException('Failed to connect to MySQL database: ' . $e->getMessage(), (int) $e->getCode(), $e);
            }
        }

        return static::$pdo;
    }

    public static function checkHealth(): bool
    {
        try {
            $pdo = static::getConnection();
            $stmt = $pdo->query('SELECT 1');
            return $stmt !== false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $pdo = static::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        return static::query($sql, $params)->fetchAll();
    }

    public static function fetchOne(string $sql, array $params = []): ?array
    {
        $result = static::query($sql, $params)->fetch();
        return $result ?: null;
    }

    public static function lastInsertId(): string
    {
        return static::getConnection()->lastInsertId();
    }
}
