<?php

declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));

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
use App\Controllers\AuthController;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');

$pass = 0;
$fail = 0;

function check(string $name, bool $result): void {
    global $pass, $fail;
    if ($result) {
        $pass++;
        echo "  [PASS] {$name}\n";
    } else {
        $fail++;
        echo "  [FAIL] {$name}\n";
    }
}

echo "=== PHASE 02 DEEP VERIFICATION: AUTHENTICATION & RBAC ===\n\n";

// 1. Database Connection & Schema Check
echo "1. Database & Schema Compatibility\n";
check("Live database ping", Database::checkHealth());
$user = Database::fetchOne("SELECT id, email, full_name, role, is_active FROM users WHERE email = :email LIMIT 1", [
    'email' => 'admin@dynamicechildrenacademy.com'
]);
check("Existing SuperAdmin account retrieved safely via PDO prepared statement", !empty($user));
check("User fields match expected types", isset($user['id'], $user['email'], $user['role']));

// 2. Initial Setup Lock Enforcement
echo "\n2. Initial Setup Lock Enforcement\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/setup';
$authController = new AuthController();
$setupRes = $authController->showSetup(new Request());
check("Setup endpoint locks with 403 when users table has records", $setupRes->getStatus() === 403);

// 3. Login Flow Verification
echo "\n3. Authentication Lifecycle Verification\n";

// A. Invalid Password Rejection
Session::destroy();
Session::start();
$failAuth = AuthService::attempt('admin@dynamicechildrenacademy.com', 'CompletelyWrongPassword_2026!');
check("Invalid password rejected", $failAuth['success'] === false);

// B. Rate Limiting Check
echo "\n4. Rate Limiting Verification\n";
for ($i = 0; $i < 5; $i++) {
    AuthService::attempt('admin@dynamicechildrenacademy.com', 'FakePassword_' . $i);
}
$rateLimited = AuthService::attempt('admin@dynamicechildrenacademy.com', 'FakePassword_Final');
check("Rate limiter triggers after consecutive failed attempts", str_contains($rateLimited['message'], 'Too many failed login attempts'));

// Clear rate limiter for subsequent tests
$key = '_login_attempts_' . md5('admin@dynamicechildrenacademy.com');
Session::remove($key);
Session::remove($key . '_time');

// C. Creation & Verification of an Isolated Test User for Lifecycle Verification
echo "\n5. Isolated Test User Lifecycle & Password Change\n";
$testEmail = 'verify_test_user_' . time() . '@academy.com';
$initialSecret = 'ComplexSecretPassword123#';
$newSecret = 'UpdatedSecretPassword456$';

$hashedInitial = password_hash($initialSecret, PASSWORD_BCRYPT, ['cost' => 12]);
$newUserId = User::create([
    'email' => $testEmail,
    'full_name' => 'Verification Test User',
    'password_hash' => $hashedInitial,
    'role' => 'EDITOR',
    'is_active' => 1,
]);
check("Test user created cleanly in MySQL (ID: {$newUserId})", $newUserId > 0);

// Successful Login with test user
Session::destroy();
Session::start();
$loginSuccess = AuthService::attempt($testEmail, $initialSecret);
check("Valid credentials login succeeded", $loginSuccess['success'] === true);
check("AuthService::check() is true after login", AuthService::check() === true);
$activeUser = AuthService::user();
check("Active user role verified as EDITOR", $activeUser['role'] === 'EDITOR');

// Password Change Flow
$hashedUpdated = password_hash($newSecret, PASSWORD_BCRYPT, ['cost' => 12]);
$pwUpdated = User::updatePassword($newUserId, $hashedUpdated);
check("Password update function succeeded", $pwUpdated === true);

// Verify old password fails
$oldFail = AuthService::attempt($testEmail, $initialSecret);
check("Old password rejected after password change", $oldFail['success'] === false);

// Verify new password succeeds
$newSuccess = AuthService::attempt($testEmail, $newSecret);
check("New password accepted after password change", $newSuccess['success'] === true);

// Clean up isolated test user
Database::query("DELETE FROM users WHERE id = :id", ['id' => $newUserId]);
$deletedCheck = User::findById($newUserId);
check("Isolated test user cleanly deleted from MySQL", $deletedCheck === null);

// Logout and clear session
AuthService::logout();

// 6. RBAC Live Route Protection
echo "\n6. Live RBAC Route Protection Pipeline\n";
$router = new Router();
require ROOT_DIR . '/routes/web.php';

// A. Unauthenticated Request to /admin -> Redirect
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin';
$respUnauth = $router->dispatch(new Request());
check("Unauthenticated /admin redirects to /admin/login", $respUnauth->getStatus() === 302 && $respUnauth->getRedirectUrl() === '/admin/login');

// B. EDITOR Role Request to /admin/users (SUPER_ADMIN ONLY) -> 403 Forbidden
Session::start();
Session::set('user_id', 9999);
Session::set('email', 'editor@academy.com');
Session::set('role', 'EDITOR');
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/users';
$respEditorUsers = $router->dispatch(new Request());
check("EDITOR blocked from /admin/users with HTTP 403", $respEditorUsers->getStatus() === 403);

// C. ADMIN Role Request to /admin/users (SUPER_ADMIN ONLY) -> 403 Forbidden
Session::set('role', 'ADMIN');
$respAdminUsers = $router->dispatch(new Request());
check("ADMIN blocked from /admin/users with HTTP 403", $respAdminUsers->getStatus() === 403);

// D. SUPER_ADMIN Role Request to /admin/users -> 200 Allowed
Session::set('role', 'SUPER_ADMIN');
$respSuperUsers = $router->dispatch(new Request());
check("SUPER_ADMIN allowed into /admin/users with HTTP 200", $respSuperUsers->getStatus() === 200);

// E. ADMIN Role Request to /admin/pages -> 200 Allowed
Session::set('role', 'ADMIN');
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/pages';
$respAdminPages = $router->dispatch(new Request());
check("ADMIN allowed into /admin/pages with HTTP 200", $respAdminPages->getStatus() === 200);

// F. EDITOR Role Request to /admin/pages -> 403 Forbidden
Session::set('role', 'EDITOR');
$respEditorPages = $router->dispatch(new Request());
check("EDITOR blocked from /admin/pages with HTTP 403", $respEditorPages->getStatus() === 403);

// G. EDITOR Role Request to /admin/blogs -> 200 Allowed
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/blogs';
$respEditorBlogs = $router->dispatch(new Request());
check("EDITOR allowed into /admin/blogs with HTTP 200", $respEditorBlogs->getStatus() === 200);

Session::destroy();

echo "\n=======================================================\n";
echo "VERIFICATION SUMMARY: {$pass} Passed | {$fail} Failed\n";
echo "=======================================================\n";

if ($fail > 0) exit(1);
exit(0);
