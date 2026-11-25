<?php

namespace App\Core;

class Session
{
    protected static bool $started = false;

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            static::$started = true;
        } else {
            $lifetime = Config::get('app.session.lifetime', 7200);
            $secure = Config::get('app.session.secure', false);

            if (!headers_sent()) {
                ini_set('session.use_only_cookies', '1');
                ini_set('session.use_strict_mode', '1');
                ini_set('session.cookie_httponly', '1');
                ini_set('session.cookie_samesite', 'Lax');

                session_set_cookie_params([
                    'lifetime' => $lifetime,
                    'path' => '/',
                    'domain' => '',
                    'secure' => $secure,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }

            @session_start();
            static::$started = true;
        }

        // Session expiration / inactivity check
        $lifetime = Config::get('app.session.lifetime', 7200);
        if (isset($_SESSION['_last_activity']) && (time() - $_SESSION['_last_activity'] > $lifetime)) {
            static::destroy();
            @session_start();
            static::$started = true;
        }
        $_SESSION['_last_activity'] = time();
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        static::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::start();
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool
    {
        static::start();
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        static::start();
        unset($_SESSION[$key]);
    }

    public static function regenerate(): void
    {
        static::start();
        if (!headers_sent()) {
            @session_regenerate_id(true);
        }
    }

    public static function destroy(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (!headers_sent() && ini_get('session.use_cookies')) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params['path'], $params['domain'],
                    $params['secure'], $params['httponly']
                );
            }
            @session_destroy();
            static::$started = false;
        } else {
            $_SESSION = [];
            static::$started = false;
        }
    }

    public static function flash(string $key, mixed $value = null): mixed
    {
        static::start();
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return null;
        }
        $val = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $val;
    }
}
