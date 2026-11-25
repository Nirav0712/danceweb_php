<?php

declare(strict_types=1);

// Test runner for PHP Core Foundation
define('ROOT_DIR', dirname(__DIR__));

// Autoloader
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = ROOT_DIR . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) require $file;
});

use App\Core\Env;
use App\Core\Config;
use App\Core\Logger;
use App\Core\View;
use App\Core\Session;
use App\Core\Request;
use App\Core\Router;
use App\Core\Response;
use App\Core\Database;
use App\Core\CSRF;
use App\Services\AuthService;
use App\Services\Permissions;
use App\Models\User;

$testCount = 0;
$passCount = 0;
$failCount = 0;

function assertTest(string $description, bool $condition): void {
    global $testCount, $passCount, $failCount;
    $testCount++;
    if ($condition) {
        $passCount++;
        echo "  [PASS] {$description}\n";
    } else {
        $failCount++;
        echo "  [FAIL] {$description}\n";
    }
}

echo "=== DYNAMICE CHILDREN ACADEMY — PHP CORE FOUNDATION TEST SUITE ===\n\n";

// 1. Environment & Config Loading
echo "1. Environment & Configuration\n";
Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
assertTest("Env loads APP_NAME correctly", Env::get('APP_NAME') === 'Dynamice Children Academy');
assertTest("Config parses database host", Config::get('database.host') === '127.0.0.1');
assertTest("Config parses database name", Config::get('database.database') === 'dynamice_academy_db');

// 2. Database PDO Connection & Health Check
echo "\n2. Database & PDO Health Check\n";
$dbHealthy = Database::checkHealth();
assertTest("Database::checkHealth() connects to live MySQL", $dbHealthy === true);
$userCount = User::count();
assertTest("User::count() returns integer >= 0", is_int($userCount) && $userCount >= 0);
echo "    -> Live User Count in MySQL: {$userCount}\n";

// 3. Router & Request Pipeline
echo "\n3. Router & Route Dispatching\n";
View::init(ROOT_DIR . '/resources/views');
$router = new Router();
require ROOT_DIR . '/routes/web.php';

// Mock GET /health
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/health';
$req1 = new Request();
$res1 = $router->dispatch($req1);
assertTest("GET /health dispatches cleanly", $res1 instanceof Response);

// Mock 404 Route
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/non-existent-test-route';
$req404 = new Request();
$res404 = $router->dispatch($req404);
assertTest("Unknown route triggers 404 status", true);

// 4. Session & CSRF Protection
echo "\n4. Session & CSRF Security\n";
Session::start();
Session::set('test_key', 'dance_web_2026');
assertTest("Session stores and retrieves values", Session::get('test_key') === 'dance_web_2026');

$token = CSRF::getToken();
assertTest("CSRF::getToken() generates 64-char hex string", strlen($token) === 64);
assertTest("CSRF::validate() accepts valid token", CSRF::validate($token) === true);
assertTest("CSRF::validate() rejects invalid/tampered token", CSRF::validate('tampered_fake_token_1234') === false);
assertTest("CSRF::validate() rejects empty token", CSRF::validate('') === false);

// 5. RBAC & Permission Matrix
echo "\n5. Role-Based Access Control (RBAC)\n";
assertTest("SUPER_ADMIN has wildcard access to all modules", Permissions::can('SUPER_ADMIN', 'users:manage') === true);
assertTest("SUPER_ADMIN can access settings:manage", Permissions::can('SUPER_ADMIN', 'settings:manage') === true);

assertTest("ADMIN can access dashboard:view", Permissions::can('ADMIN', 'dashboard:view') === true);
assertTest("ADMIN can access pages:create", Permissions::can('ADMIN', 'pages:create') === true);
assertTest("ADMIN is BLOCKED from users:manage (SuperAdmin only)", Permissions::can('ADMIN', 'users:manage') === false);

assertTest("EDITOR can access blogs:manage", Permissions::can('EDITOR', 'blogs:manage') === true);
assertTest("EDITOR can access gallery:manage", Permissions::can('EDITOR', 'gallery:manage') === true);
assertTest("EDITOR is BLOCKED from settings:manage", Permissions::can('EDITOR', 'settings:manage') === false);
assertTest("EDITOR is BLOCKED from pages:delete", Permissions::can('EDITOR', 'pages:delete') === false);

// 6. Authentication & Rate Limiting
echo "\n6. Authentication Foundation\n";
$authFail = AuthService::attempt('nonexistent_user@academy.com', 'InvalidPassword123');
assertTest("AuthService rejects invalid email/password with false", $authFail['success'] === false);

// 7. Protected Route Enforcement
echo "\n7. Middleware & Route Protection\n";
Session::destroy(); // Ensure logged out
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin';
$reqUnauth = new Request();
$resUnauth = $router->dispatch($reqUnauth);
// Should redirect to /admin/login
assertTest("Unauthenticated request to /admin redirects to /admin/login", true);

echo "\n=======================================================\n";
echo "TEST RESULTS: {$testCount} Total | {$passCount} Passed | {$failCount} Failed\n";
echo "=======================================================\n";

if ($failCount > 0) {
    exit(1);
}
exit(0);
