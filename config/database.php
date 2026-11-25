<?php

use App\Core\Env;

// Support standard Hostinger, Laravel, and custom database environment variable names
$host = Env::get('DB_HOST', Env::get('MYSQL_HOST', '127.0.0.1'));
$port = Env::get('DB_PORT', Env::get('MYSQL_PORT', '3306'));
$database = Env::get('DB_NAME', Env::get('DB_DATABASE', Env::get('MYSQL_DATABASE', 'dynamice_academy_db')));
$username = Env::get('DB_USER', Env::get('DB_USERNAME', Env::get('MYSQL_USER', 'root')));
$password = Env::get('DB_PASS', Env::get('DB_PASSWORD', Env::get('MYSQL_PASSWORD', '')));
$charset  = Env::get('DB_CHARSET', 'utf8mb4');

return [
    'host' => $host,
    'port' => $port,
    'database' => $database,
    'username' => $username,
    'password' => $password,
    'charset' => $charset,
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
