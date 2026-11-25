<?php

namespace App\Services;

use App\Core\Session;
use App\Models\User;

class AuthService
{
    public static function attempt(string $email, string $password): array
    {
        // Rate limiting check
        $attemptsKey = '_login_attempts_' . md5($email);
        $attempts = Session::get($attemptsKey, 0);
        $lastAttempt = Session::get($attemptsKey . '_time', 0);

        if ($attempts >= 5 && (time() - $lastAttempt < 300)) {
            $remaining = 300 - (time() - $lastAttempt);
            return ['success' => false, 'message' => "Too many failed login attempts. Please wait {$remaining} seconds."];
        }

        $user = User::findByEmail($email);
        if (!$user) {
            static::recordFailedAttempt($attemptsKey);
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        if (empty($user['is_active'])) {
            return ['success' => false, 'message' => 'Your account is deactivated. Contact an administrator.'];
        }

        if (!password_verify($password, $user['password_hash'])) {
            static::recordFailedAttempt($attemptsKey);
            return ['success' => false, 'message' => 'Invalid email or password.'];
        }

        // Reset rate limiter on success
        Session::remove($attemptsKey);
        Session::remove($attemptsKey . '_time');

        // Session regeneration to prevent fixation
        Session::regenerate();

        Session::set('user_id', (int) $user['id']);
        Session::set('email', $user['email']);
        Session::set('full_name', $user['full_name']);
        Session::set('role', $user['role']);
        Session::set('logged_in_at', time());

        User::updateLastLogin((int) $user['id']);

        return ['success' => true, 'user' => $user];
    }

    public static function logout(): void
    {
        Session::destroy();
    }

    public static function check(): bool
    {
        return Session::has('user_id');
    }

    public static function user(): ?array
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            return null;
        }

        return [
            'id' => $userId,
            'email' => Session::get('email'),
            'full_name' => Session::get('full_name'),
            'role' => Session::get('role'),
        ];
    }

    protected static function recordFailedAttempt(string $key): void
    {
        $attempts = Session::get($key, 0) + 1;
        Session::set($key, $attempts);
        Session::set($key . '_time', time());
    }
}
