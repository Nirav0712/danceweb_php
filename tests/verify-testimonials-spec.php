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
use App\Core\Request;
use App\Core\Router;
use App\Core\Database;
use App\Core\Session;
use App\Core\CSRF;
use App\Controllers\PublicController;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');

echo "=== 1. VERIFYING HOMEPAGE RENDERING (WORDS FROM OUR FAMILIES) ===\n";
$publicController = new PublicController();
$request = new Request();
$res = $publicController->home($request);
$html = $res->getBody();

$checks = [
    'Section present (id="parent-reflections-section")' => strpos($html, 'id="parent-reflections-section"') !== false,
    'Padding matches Services & Disciplines (w-full px-3 sm:px-6 lg:px-8 xl:px-12)' => (
        strpos($html, '<div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">') !== false
    ),
    'Top badge: PARENT REFLECTIONS' => strpos($html, 'PARENT REFLECTIONS') !== false,
    'Heading: Words From Our Families' => strpos($html, 'Words From Our Families') !== false,
    '3-Column grid classes applied (md:grid-cols-2 lg:grid-cols-3)' => strpos($html, 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3') !== false,
    'White cards with rounded-3xl applied' => strpos($html, 'bg-white rounded-3xl p-6 sm:p-7') !== false,
    'Pink quote icons present' => strpos($html, 'text-pink-400') !== false,
    '5 Stars rating icons present' => strpos($html, 'text-amber-400 shrink-0 select-none') !== false,
    'Bhavna Patel testimonial rendered' => strpos($html, 'Bhavna Patel') !== false,
    'Ramesh Shah testimonial rendered' => strpos($html, 'Ramesh Shah') !== false,
    'Megha Dave testimonial rendered' => strpos($html, 'Megha Dave') !== false,
    'Old grey What Parents & Students Say replaced' => strpos($html, 'What Parents & Students Say') === false,
];

$allPassed = true;
foreach ($checks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

echo "\n=== 2. VERIFYING ADMIN TESTIMONIALS MANAGEMENT & HEADING UPDATE ===\n";
$router = new Router();
require ROOT_DIR . '/routes/web.php';

$admin = Database::fetchOne("SELECT * FROM users WHERE role = 'SUPER_ADMIN' LIMIT 1");
Session::set('user_id', (int)$admin['id']);
Session::set('role', $admin['role']);
Session::set('email', $admin['email']);
Session::set('full_name', $admin['full_name']);

$csrfToken = CSRF::getToken();

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/testimonials';
$_POST = [];
$adminRes = $router->dispatch(new Request());
$adminHtml = $adminRes->getBody();

$adminChecks = [
    'Admin testimonials page loads (status 200)' => $adminRes->getStatus() === 200,
    'Showcase settings card present' => strpos($adminHtml, 'Homepage Showcase Settings (Words From Our Families)') !== false,
    'Heading form action /admin/testimonials/heading present' => strpos($adminHtml, 'action="/admin/testimonials/heading"') !== false,
    'Add review button & modal present' => strpos($adminHtml, 'createTestimonialModal') !== false,
    'Edit modal present' => strpos($adminHtml, 'editTestimonialModal') !== false,
];

foreach ($adminChecks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

echo "\n=== 3. TESTING POST /admin/testimonials/heading ===\n";
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/admin/testimonials/heading';
$_POST = [
    'csrf_token' => $csrfToken,
    'content' => 'PARENT REFLECTIONS',
    'heading' => 'Words From Our Families [QA-VERIFIED]',
    'subheading' => 'Authentic reflections from parents and students experiencing our creative pedagogy.',
];

$updateReq = new Request();
$updateRes = $router->dispatch($updateReq);
$postSuccess = $updateRes->getStatus() === 302;
echo ($postSuccess ? "  [PASS] " : "  [FAIL] ") . "POST /admin/testimonials/heading redirected with 302\n";
if (!$postSuccess) $allPassed = false;

$sec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'testimonials'");
$dbUpdated = !empty($sec) && strpos($sec['heading'], '[QA-VERIFIED]') !== false;
echo ($dbUpdated ? "  [PASS] " : "  [FAIL] ") . "Section record saved in database\n";
if (!$dbUpdated) $allPassed = false;

// Revert test heading back to clean title
Database::query("UPDATE sections SET heading = 'Words From Our Families' WHERE section_key = 'testimonials'");
echo "  [PASS] Cleaned up QA test heading back to original\n";

echo "\n=== 4. REGRESSION CHECKS ACROSS PREVIOUS SECTIONS ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_POST = [];
$regRes = $router->dispatch(new Request());
$regHtml = $regRes->getBody();

$regChecks = [
    'Full-width hero banner intact' => strpos($regHtml, 'id="hero-slider-section"') !== false,
    '7-tab curriculum section intact' => strpos($regHtml, 'id="curriculum-disciplines"') !== false,
    'Tour flags carousel intact' => strpos($regHtml, 'id="tour-flags-showcase"') !== false,
    'Awards showcase intact' => strpos($regHtml, 'id="awards-showcase-section"') !== false,
    'Words from families section intact' => strpos($regHtml, 'id="parent-reflections-section"') !== false,
];

foreach ($regChecks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

if ($allPassed) {
    echo "\n=======================================================\n";
    echo "WORDS FROM OUR FAMILIES SHOWCASE: 100% SPEC VERIFIED\n";
    echo "=======================================================\n";
} else {
    echo "\n>>> SOME CHECKS FAILED! <<<\n";
    exit(1);
}
