<?php

namespace App\Core;

class Env
{
    protected static array $variables = [];
    protected static bool $loaded = false;

    public static function load(string $filePath): void
    {
        // 1. If explicit path exists, use it
        $target = null;
        if (file_exists($filePath)) {
            $target = $filePath;
        } else {
            // 2. Try common Hostinger & subfolder fallback locations
            $dir = dirname($filePath);
            $candidatePaths = [
                $dir . '/.env',
                dirname($dir) . '/.env',
                getcwd() . '/.env',
                dirname(getcwd()) . '/.env',
                ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/.env',
            ];

            foreach ($candidatePaths as $cand) {
                if (!empty($cand) && file_exists($cand)) {
                    $target = $cand;
                    break;
                }
            }
        }

        if ($target === null) {
            return;
        }

        $lines = @file($target, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            $content = @file_get_contents($target);
            if ($content !== false) {
                $lines = explode("\n", str_replace("\r", "", $content));
            } else {
                return;
            }
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val);

                // Strip surrounding quotes
                if ((str_starts_with($val, '"') && str_ends_with($val, '"')) ||
                    (str_starts_with($val, "'") && str_ends_with($val, "'"))) {
                    $val = substr($val, 1, -1);
                }

                // Boolean & null conversion
                $lower = strtolower($val);
                if ($lower === 'true') $val = true;
                elseif ($lower === 'false') $val = false;
                elseif ($lower === 'null') $val = null;

                static::$variables[$key] = $val;
                $_ENV[$key] = $val;
                putenv("{$key}={$val}");
            }
        }
        static::$loaded = true;
    }

    public static function isLoaded(): bool
    {
        return static::$loaded;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::$variables[$key] ?? $_ENV[$key] ?? getenv($key) ?: $default;
    }
}
