<?php

namespace App\Core;

class Database
{
    protected static ?\PDO $pdo = null;

    public static function getConnection(): \PDO
    {
        if (static::$pdo === null) {
            $host = Config::get('database.host');
            $port = Config::get('database.port', '3306');
            $dbname = Config::get('database.database');
            $charset = Config::get('database.charset', 'utf8mb4');
            $username = Config::get('database.username');
            $password = Config::get('database.password');
            $options = Config::get('database.options', [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ]);

            // If environment variables were not loaded and credentials appear unset in production
            $appEnv = Config::get('app.env', 'development');
            if (empty($dbname) || empty($username)) {
                $errorMsg = 'Database configuration is incomplete. Please check your Hostinger .env configuration file.';
                Logger::error($errorMsg);
                throw new \RuntimeException($errorMsg);
            }

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";

            try {
                static::$pdo = new \PDO($dsn, $username, $password, $options);
            } catch (\PDOException $e) {
                // Sanitize log: log driver and sanitized error message without leaking credentials
                $safeError = "Database Connection Failed [Code: {$e->getCode()}] for database '{$dbname}' on host '{$host}': " . $e->getMessage();
                Logger::error($safeError);
                
                // Throw safe exception without password
                throw new \RuntimeException("Database connection failed for database '{$dbname}'. Ensure your Hostinger .env contains the correct DB_HOST, DB_NAME, DB_USER, and DB_PASS.", (int) $e->getCode(), $e);
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
        $res = static::query($sql, $params)->fetch();
        return $res === false ? null : $res;
    }

    public static function lastInsertId(): string
    {
        return static::getConnection()->lastInsertId();
    }
}
