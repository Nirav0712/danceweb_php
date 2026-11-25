<?php
/**
 * Dynamic Children Academy — Production Web Root Entry Point
 *
 * This file serves as the front controller when Hostinger's document root
 * points directly to the repository root (e.g. public_html/ contains app, config, public, etc.).
 *
 * It seamlessly forwards execution to public/index.php while keeping paths intact.
 */

declare(strict_types=1);

$publicIndex = __DIR__ . '/public/index.php';

if (file_exists($publicIndex)) {
    require_once $publicIndex;
} else {
    http_response_code(500);
    echo 'Application error: public/index.php not found.';
}
