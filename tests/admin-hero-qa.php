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
use App\Models\User;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');
Session::start();

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

echo "=== HERO CMS ADMIN CRUD & PUBLIC SYNC VERIFICATION ===\n\n";

$router = new Router();
require ROOT_DIR . '/routes/web.php';

// 1. Authenticate as SUPER_ADMIN via Session helper
$admin = User::findByEmail('admin@dynamicechildrenacademy.com');
if (!$admin) {
    $admin = Database::fetchOne("SELECT * FROM users WHERE role = 'SUPER_ADMIN' LIMIT 1");
}
Session::set('user_id', (int)$admin['id']);
Session::set('role', $admin['role']);
Session::set('email', $admin['email']);
Session::set('full_name', $admin['full_name']);

$csrfToken = CSRF::getToken();

function testDispatch(string $method, string $uri, array $post = [], ?Router $router = null): Response {
    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri;
    $_POST = $post;
    return $router->dispatch(new Request());
}

// 2. Test Admin Hero Index Page
$res = testDispatch('GET', '/admin/hero', [], $router);
check("Admin Hero Index (/admin/hero) dispatches with HTTP 200", $res->getStatus() === 200);

// 3. Test Updating Hero Heading from Admin
$headingRes = testDispatch('POST', '/admin/hero/heading', [
    'csrf_token' => $csrfToken,
    'heading' => 'Culture Is a Way of Life',
    'subheading' => 'Premier Indian Dance Academy',
], $router);
check("Admin Update Heading returns HTTP 302 redirect", $headingRes->getStatus() === 302);

// Verify DB persistence of heading
$sec = Database::fetchOne("SELECT heading, subheading FROM sections WHERE section_key = 'hero' LIMIT 1");
check("Hero heading persisted in sections table", $sec && $sec['heading'] === 'Culture Is a Way of Life');

// 4. Test Adding a New Hero Slide
$createRes = testDispatch('POST', '/admin/hero/slides', [
    'csrf_token' => $csrfToken,
    'title' => 'QA Automated Test Slide',
    'image_url' => '/assets/homepage/2025UK.jpeg',
    'sort_order' => '99',
    'is_active' => '1',
], $router);
check("Admin Create Hero Slide returns HTTP 302 redirect", $createRes->getStatus() === 302);

$createdSlide = Database::fetchOne("SELECT * FROM hero_slides WHERE title = 'QA Automated Test Slide' ORDER BY id DESC LIMIT 1");
check("New slide persisted in hero_slides table", !empty($createdSlide));

// 5. Test Editing the Hero Slide
if (!empty($createdSlide)) {
    $slideId = (int)$createdSlide['id'];
    $updateRes = testDispatch('POST', "/admin/hero/slides/{$slideId}/update", [
        'csrf_token' => $csrfToken,
        'title' => 'QA Automated Test Slide — Updated',
        'image_url' => '/assets/homepage/4H7A9667.jpg',
        'sort_order' => '95',
        'is_active' => '1',
    ], $router);
    check("Admin Edit Hero Slide returns HTTP 302 redirect", $updateRes->getStatus() === 302);

    $updatedSlide = Database::fetchOne("SELECT * FROM hero_slides WHERE id = :id", ['id' => $slideId]);
    check("Slide updates persisted in hero_slides table", $updatedSlide && $updatedSlide['title'] === 'QA Automated Test Slide — Updated');

    // 6. Test Public Homepage Synchronisation
    $publicRes = testDispatch('GET', '/', [], $router);
    $html = $publicRes->getBody();
    check("Public homepage rendered with updated slide image", strpos($html, '/assets/homepage/4H7A9667.jpg') !== false);
    check("Public homepage rendered with hero heading", strpos($html, 'Culture Is a') !== false && strpos($html, 'Way of Life') !== false);

    // 7. Test Deleting the Hero Slide
    $deleteRes = testDispatch('POST', "/admin/hero/slides/{$slideId}/delete", [
        'csrf_token' => $csrfToken,
    ], $router);
    check("Admin Delete Hero Slide returns HTTP 302 redirect", $deleteRes->getStatus() === 302);

    $deletedSlide = Database::fetchOne("SELECT * FROM hero_slides WHERE id = :id", ['id' => $slideId]);
    check("Slide cleanly removed from hero_slides table", empty($deletedSlide));
}

echo "\nSummary: {$pass} Passed | {$fail} Failed\n";
exit($fail === 0 ? 0 : 1);
