<?php

namespace App\Helpers;

use App\Core\CSRF;
use App\Core\Session;

class Security
{
    public static function e(?string $string): string
    {
        return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
    }

    public static function csrfField(): string
    {
        return CSRF::field();
    }

    public static function csrfToken(): string
    {
        return CSRF::getToken();
    }
}
