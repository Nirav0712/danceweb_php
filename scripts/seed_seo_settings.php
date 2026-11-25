<?php

require_once __DIR__ . '/../app/Core/Env.php';
require_once __DIR__ . '/../app/Core/Config.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Env;
use App\Core\Config;
use App\Core\Database;

Env::load(dirname(__DIR__) . '/.env');
Config::load(dirname(__DIR__) . '/config');

$keys = [
    [
        'key' => 'default_meta_title',
        'val' => 'Dynamice Children Academy — Premier Dance Institute Gujarat',
        'type' => 'STRING',
        'desc' => 'Global default browser title when not overridden by specific page'
    ],
    [
        'key' => 'default_meta_description',
        'val' => 'Premier cultural dance institution in Ahmedabad, Gujarat, training children in authentic Indian folk, classical, and contemporary arts.',
        'type' => 'STRING',
        'desc' => 'Global default search engine meta description'
    ],
    [
        'key' => 'google_site_verification',
        'val' => '',
        'type' => 'STRING',
        'desc' => 'Google Search Console verification meta tag token'
    ],
    [
        'key' => 'google_analytics_id',
        'val' => '',
        'type' => 'STRING',
        'desc' => 'Google Analytics (GA4) Measurement ID e.g. G-XXXXX'
    ]
];

foreach ($keys as $k) {
    $exists = Database::fetchOne('SELECT id FROM website_settings WHERE setting_key = :k', ['k' => $k['key']]);
    if (!$exists) {
        Database::query(
            'INSERT INTO website_settings (setting_key, setting_value, setting_type, description, updated_at) VALUES (:k, :v, :t, :d, NOW())',
            ['k' => $k['key'], 'v' => $k['val'], 't' => $k['type'], 'd' => $k['desc']]
        );
        echo "Added setting: {$k['key']}\n";
    } else {
        echo "Setting already exists: {$k['key']}\n";
    }
}
echo "SEO settings sync complete.\n";
