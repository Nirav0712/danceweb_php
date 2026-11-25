<?php

namespace App\Core;

class CSRF
{
    public static function getToken(): string
    {
        Session::start();
        $token = Session::get('_csrf_token');
        if (empty($token) || !is_string($token)) {
            $token = bin2hex(random_bytes(32));
            Session::set('_csrf_token', $token);
        }
        return $token;
    }

    public static function token(): string
    {
        return static::getToken();
    }

    public static function validate(?string $token): bool
    {
        Session::start();
        $stored = Session::get('_csrf_token');
        if (empty($stored) || empty($token)) {
            return false;
        }
        return hash_equals($stored, $token);
    }

    public static function field(): string
    {
        $token = static::getToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
