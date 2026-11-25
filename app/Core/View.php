<?php

namespace App\Core;

class View
{
    protected static string $viewPath;

    public static function init(string $path): void
    {
        static::$viewPath = rtrim($path, '/\\');
    }

    public static function render(string $template, array $data = []): string
    {
        $file = static::$viewPath . '/' . str_replace('.', '/', $template) . '.php';
        if (!file_exists($file)) {
            throw new \RuntimeException("View template not found: {$template} ({$file})");
        }

        extract($data);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}
