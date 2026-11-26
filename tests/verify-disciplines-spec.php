<?php

declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));

spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = ROOT_DIR . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

require_once ROOT_DIR . '/app/Core/Env.php';
require_once ROOT_DIR . '/app/Core/Config.php';
require_once ROOT_DIR . '/app/Core/Logger.php';
require_once ROOT_DIR . '/app/Core/Database.php';
require_once ROOT_DIR . '/app/Core/View.php';

use App\Core\Config;
use App\Core\Env;
use App\Core\Logger;
use App\Core\View;
use App\Core\Request;
use App\Controllers\PublicController;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');

echo "=== SERVICES, DISCIPLINES & STAGE MOMENTS 7-TAB VERIFICATION ===\n\n";

$controller = new PublicController();
$request = new Request([], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/']);
$response = $controller->home($request);

$html = $response->getBody();

// 1. Check HTTP status
$status = method_exists($response, 'getStatus') ? $response->getStatus() : ($response->status ?? 200);
if ($status === 200) {
    echo "  [PASS] Homepage dispatches with HTTP 200\n";
} else {
    echo "  [FAIL] Homepage returned HTTP " . $status . "\n";
    exit(1);
}

// 2. Check Section Header
$requiredHeaders = [
    'ACADEMY CURRICULUM & VISUAL ARCHIVE',
    'Services, Disciplines & Stage Moments',
    'Explore our structured child-centric pedagogy, diverse genres, and authentic stage recitals.',
];
foreach ($requiredHeaders as $header) {
    if (strpos($html, $header) !== false) {
        echo "  [PASS] Section Header contains: '{$header}'\n";
    } else {
        echo "  [FAIL] Missing header text: '{$header}'\n";
        exit(1);
    }
}

// 3. Check All 7 Tabs
$tabs = [
    'SERVICE' => 'service',
    'DANCE' => 'dance',
    'GYMNASTICS' => 'gymnastics',
    'DRAMA SPEAKING' => 'drama',
    'MODELING' => 'modeling',
    'DRAWING' => 'drawing',
    'SPIRITUAL' => 'spiritual',
];

foreach ($tabs as $label => $key) {
    if (strpos($html, "data-discipline=\"{$key}\"") !== false && strpos($html, "id=\"tab-btn-{$key}\"") !== false) {
        echo "  [PASS] Tab button found: '{$label}' (key: {$key})\n";
    } else {
        echo "  [FAIL] Missing tab button: '{$label}' (key: {$key})\n";
        exit(1);
    }
}

// 4. Check All 7 Panels and Images
$expectedImages = [
    'service' => '/assets/homepage/services/service.jpg',
    'dance' => '/assets/homepage/services/dance.jpg',
    'gymnastics' => '/assets/homepage/services/gymnastics.jpg',
    'drama' => '/assets/homepage/services/drama.jpg',
    'modeling' => '/assets/homepage/services/modeling.jpg',
    'drawing' => '/assets/homepage/services/drawing.jpg',
    'spiritual' => '/assets/homepage/services/spiritual.jpg',
];

foreach ($expectedImages as $key => $imgPath) {
    if (strpos($html, "id=\"panel-{$key}\"") !== false) {
        echo "  [PASS] Content panel found for: '{$key}'\n";
    } else {
        echo "  [FAIL] Missing content panel for: '{$key}'\n";
        exit(1);
    }

    $diskPath = ROOT_DIR . '/public' . $imgPath;
    if (file_exists($diskPath)) {
        echo "  [PASS] Image asset exists on disk: '{$imgPath}' (" . round(filesize($diskPath)/1024, 1) . " KB)\n";
    } else {
        echo "  [FAIL] Missing image asset on disk: '{$diskPath}'\n";
        exit(1);
    }
}

// 5. Check Old Director Section is Removed from below hero
if (strpos($html, "Message from the Founder") === false) {
    echo "  [PASS] Old 'Message from the Founder' section cleanly replaced\n";
} else {
    echo "  [FAIL] Old 'Message from the Founder' still present\n";
    exit(1);
}

// 6. Check JavaScript interactivity presence
if (strpos($html, "discipline-tab-btn") !== false && strpos($html, "selectTab") !== false) {
    echo "  [PASS] Interactive Tab Switcher JavaScript present\n";
} else {
    echo "  [FAIL] Missing Tab Switcher JavaScript\n";
    exit(1);
}

echo "\n=======================================================\n";
echo "ALL 7-TAB CURRICULUM SPECIFICATIONS VERIFIED: 100% PASS\n";
echo "=======================================================\n";
