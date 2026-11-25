<?php

namespace App\Services;

class CacheService
{
    protected static ?string $cacheDir = null;
    protected static array $memoryCache = [];

    /**
     * Get the cache directory path
     */
    protected static function getCacheDir(): string
    {
        if (static::$cacheDir === null) {
            static::$cacheDir = dirname(__DIR__, 2) . '/storage/cache';
            if (!is_dir(static::$cacheDir)) {
                @mkdir(static::$cacheDir, 0755, true);
            }
        }
        return static::$cacheDir;
    }

    /**
     * Hash key to safe filename
     */
    protected static function keyToPath(string $key): string
    {
        $hash = md5($key);
        return static::getCacheDir() . '/cache_' . $hash . '.json';
    }

    /**
     * Retrieve an item from the cache
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, static::$memoryCache)) {
            $item = static::$memoryCache[$key];
            if ($item['expires_at'] === 0 || $item['expires_at'] > time()) {
                return $item['value'];
            }
            unset(static::$memoryCache[$key]);
        }

        $path = static::keyToPath($key);
        if (!file_exists($path)) {
            return $default;
        }

        $raw = @file_get_contents($path);
        if (!$raw) {
            return $default;
        }

        $data = json_decode($raw, true);
        if (!is_array($data) || !isset($data['expires_at'])) {
            @unlink($path);
            return $default;
        }

        if ($data['expires_at'] !== 0 && $data['expires_at'] < time()) {
            @unlink($path);
            return $default;
        }

        static::$memoryCache[$key] = $data;
        return $data['value'];
    }

    /**
     * Store an item in the cache
     */
    public static function set(string $key, mixed $value, int $ttlSeconds = 3600): void
    {
        $expiresAt = ($ttlSeconds > 0) ? (time() + $ttlSeconds) : 0;
        $data = [
            'key' => $key,
            'expires_at' => $expiresAt,
            'value' => $value,
        ];

        static::$memoryCache[$key] = $data;
        $path = static::keyToPath($key);
        @file_put_contents($path, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Remember item or compute and cache it
     */
    public static function remember(string $key, int $ttlSeconds, callable $callback): mixed
    {
        $cached = static::get($key);
        if ($cached !== null) {
            return $cached;
        }

        $value = $callback();
        static::set($key, $value, $ttlSeconds);
        return $value;
    }

    /**
     * Forget a specific cache key
     */
    public static function forget(string $key): void
    {
        unset(static::$memoryCache[$key]);
        $path = static::keyToPath($key);
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    /**
     * Flush all application caches
     */
    public static function flush(): void
    {
        static::$memoryCache = [];
        $dir = static::getCacheDir();
        $files = @glob($dir . '/cache_*.json');
        if (is_array($files)) {
            foreach ($files as $f) {
                @unlink($f);
            }
        }
        SeoService::clearCache();
    }
}
