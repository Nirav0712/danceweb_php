<?php

namespace App\Models;

use App\Core\Database;

class User
{
    public static function findById(int $id): ?array
    {
        return Database::fetchOne('SELECT * FROM users WHERE id = :id LIMIT 1', ['id' => $id]);
    }

    public static function findByEmail(string $email): ?array
    {
        return Database::fetchOne('SELECT * FROM users WHERE email = :email LIMIT 1', ['email' => $email]);
    }

    public static function count(): int
    {
        $row = Database::fetchOne('SELECT COUNT(*) as total FROM users');
        return (int) ($row['total'] ?? 0);
    }

    public static function create(array $data): int
    {
        $sql = 'INSERT INTO users (email, password_hash, full_name, role, is_active, created_at, updated_at) 
                VALUES (:email, :password_hash, :full_name, :role, :is_active, NOW(), NOW())';
        
        Database::query($sql, [
            'email' => $data['email'],
            'password_hash' => $data['password_hash'],
            'full_name' => $data['full_name'],
            'role' => $data['role'] ?? 'ADMIN',
            'is_active' => $data['is_active'] ?? 1,
        ]);

        return (int) Database::lastInsertId();
    }

    public static function updatePassword(int $userId, string $newPasswordHash): bool
    {
        $sql = 'UPDATE users SET password_hash = :hash, updated_at = NOW() WHERE id = :id';
        Database::query($sql, [
            'hash' => $newPasswordHash,
            'id' => $userId,
        ]);
        return true;
    }

    public static function updateLastLogin(int $userId): void
    {
        Database::query('UPDATE users SET last_login_at = NOW(), updated_at = NOW() WHERE id = :id', ['id' => $userId]);
    }
}
