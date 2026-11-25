<?php

namespace App\Core;

class Config
{
    protected static array $items = [];

    public static function load(string $directory): void
    {
        if (!is_dir($directory)) {
            return;
        }

        $files = glob($directory . '/*.php');
        foreach ($files as $file) {
            $key = basename($file, '.php');
            static::$items[$key] = require $file;
        }
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $data = static::$items;

        foreach ($segments as $segment) {
            if (!is_array($data) || !array_key_exists($segment, $data)) {
                return $default;
            }
            $data = $data[$segment];
        }

        return $data;
    }
}
