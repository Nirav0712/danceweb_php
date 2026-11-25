<?php

use App\Core\Env;

return [
    'name' => Env::get('APP_NAME', 'Dynamice Children Academy'),
    'env' => Env::get('APP_ENV', 'production'),
    'debug' => (bool) Env::get('APP_DEBUG', false),
    'url' => Env::get('APP_URL', 'http://localhost'),
    'session' => [
        'lifetime' => (int) Env::get('SESSION_LIFETIME', 7200),
        'secure' => (bool) Env::get('SESSION_SECURE', false),
    ],
];
