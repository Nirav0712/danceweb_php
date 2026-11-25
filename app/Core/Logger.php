<?php

namespace App\Core;

class Logger
{
    protected static ?string $logFile = null;

    public static function init(string $storagePath): void
    {
        static::$logFile = rtrim($storagePath, '/\\') . '/logs/app.log';
    }

    public static function log(string $level, string $message, array $context = []): void
    {
        if (!static::$logFile) {
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_SLASHES) : '';
        $entry = "[{$timestamp}] [{$level}] {$message}{$contextStr}" . PHP_EOL;

        @file_put_contents(static::$logFile, $entry, FILE_APPEND | LOCK_EX);
    }

    public static function info(string $message, array $context = []): void
    {
        static::log('INFO', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        static::log('ERROR', $message, $context);
    }
}
