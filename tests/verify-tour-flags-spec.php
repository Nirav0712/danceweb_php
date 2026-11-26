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
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;
use App\Core\CSRF;
use App\Core\Database;
use App\Controllers\PublicController;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');
Session::start();

echo "=== TOUR FLAGS CAROUSEL & CMS MANAGEMENT AUDIT ===\n\n";

// 1. Check Homepage rendering
$publicController = new PublicController();
$request = new Request([], [], [], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/']);
$response = $publicController->home($request);

$html = $response->getBody();

// Verify section presence
if (strpos($html, 'id="tour-flags-showcase"') !== false) {
    echo "  [PASS] Tour flags showcase section present (#tour-flags-showcase)\n";
} else {
    echo "  [FAIL] Missing tour flags showcase section\n";
    exit(1);
}

// Verify Magenta Background
if (strpos($html, 'bg-[#c9175d]') !== false) {
    echo "  [PASS] Magenta berry background color applied (bg-[#c9175d])\n";
} else {
    echo "  [FAIL] Missing magenta background\n";
    exit(1);
}

// Verify Heading and Subtitle
if (strpos($html, 'Participated International Festivals in last 12 years All Over world') !== false) {
    echo "  [PASS] Exact Heading matching SS 1 present\n";
} else {
    echo "  [FAIL] Missing SS 1 heading\n";
    exit(1);
}

if (strpos($html, 'Click any country flag to view live performance photos') !== false) {
    echo "  [PASS] Subtitle matching SS 1 present\n";
} else {
    echo "  [FAIL] Missing SS 1 subtitle\n";
    exit(1);
}

// Verify Carousel Arrows and Padding
if (strpos($html, 'tour-flags-prev-btn') !== false && strpos($html, 'tour-flags-next-btn') !== false) {
    echo "  [PASS] Carousel navigation buttons present (prev and next)\n";
} else {
    echo "  [FAIL] Missing carousel navigation buttons\n";
    exit(1);
}

if (strpos($html, 'px-3 sm:px-6 lg:px-8 xl:px-12') !== false) {
    echo "  [PASS] Padding matches Services & Disciplines section (w-full px-3 sm:px-6 lg:px-8 xl:px-12)\n";
} else {
    echo "  [FAIL] Missing requested left & right padding\n";
    exit(1);
}

// 2. Admin Controller QA & CMS Sync
$router = new Router();
require ROOT_DIR . '/routes/web.php';

$admin = Database::fetchOne("SELECT * FROM users WHERE role = 'SUPER_ADMIN' LIMIT 1");
Session::set('user_id', (int)$admin['id']);
Session::set('role', $admin['role']);
Session::set('email', $admin['email']);
Session::set('full_name', $admin['full_name']);

$csrfToken = CSRF::getToken();

// Test admin index dispatches
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/tour-flags';
$_POST = [];
$adminRes = $router->dispatch(new Request());
if ($adminRes->getStatus() === 200) {
    echo "  [PASS] Admin Tour Flags index (/admin/tour-flags) dispatches HTTP 200\n";
} else {
    echo "  [FAIL] Admin index returned HTTP " . $adminRes->getStatus() . "\n";
    exit(1);
}

// Test admin update heading
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/admin/tour-flags/heading';
$_POST = [
    'csrf_token' => $csrfToken,
    'heading' => 'Participated International Festivals in last 12 years All Over world [QA-VERIFIED]',
    'subheading' => 'Click any country flag to view live performance photos & festival achievements.',
];
$updateHeadingRes = $router->dispatch(new Request());
if ($updateHeadingRes->getStatus() === 302) {
    echo "  [PASS] Admin update heading dispatches HTTP 302 redirect\n";
} else {
    echo "  [FAIL] Admin update heading failed with status " . $updateHeadingRes->getStatus() . "\n";
    exit(1);
}

// Verify updated heading is in DB
$dbHeading = Database::fetchOne("SELECT heading FROM sections WHERE section_key = 'tour_flags'")['heading'] ?? '';
if (strpos($dbHeading, '[QA-VERIFIED]') !== false) {
    echo "  [PASS] Heading persisted into sections table\n";
} else {
    echo "  [FAIL] Heading not updated in sections table\n";
    exit(1);
}

// Revert QA heading back to original
Database::query("UPDATE sections SET heading = 'Participated International Festivals in last 12 years All Over world' WHERE section_key = 'tour_flags'");
echo "  [PASS] Cleaned up QA test heading\n";

echo "\n=======================================================\n";
echo "TOUR FLAGS CAROUSEL & ADMIN SPECIFICATION: 100% PASS\n";
echo "=======================================================\n";
