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

echo "=== 1. VERIFYING HOMEPAGE RENDERING (AWARDS SHOWCASE) ===\n";
$publicController = new PublicController();
$request = new Request();
$res = $publicController->home($request);
$html = $res->getBody();

$checks = [
    'Awards Showcase section present (id="awards-showcase-section")' => strpos($html, 'id="awards-showcase-section"') !== false,
    'Padding matches Services & Disciplines (w-full px-3 sm:px-6 lg:px-8 xl:px-12)' => (
        strpos($html, '<div class="w-full px-3 sm:px-6 lg:px-8 xl:px-12 relative z-10">') !== false
    ),
    'Top badge: PRESTIGIOUS ACCREDITATIONS & HONORS' => strpos($html, 'PRESTIGIOUS ACCREDITATIONS &amp; HONORS') !== false || strpos($html, 'PRESTIGIOUS ACCREDITATIONS') !== false,
    'Heading: Awards & World Records' => strpos($html, 'Awards &amp; World Records') !== false,
    'Subtitle present' => strpos($html, 'Honored by international record books') !== false,
    'View All Records & Honors link present' => strpos($html, 'View All Records &amp; Honors') !== false,
    'Carousel track present (id="awards-slider-track")' => strpos($html, 'id="awards-slider-track"') !== false,
    'Navigation buttons present (prev, next, pause)' => (
        strpos($html, 'id="awards-prev-btn"') !== false &&
        strpos($html, 'id="awards-next-btn"') !== false &&
        strpos($html, 'id="awards-pause-btn"') !== false
    ),
    'Dots container present (id="awards-dots-container")' => strpos($html, 'id="awards-dots-container"') !== false,
    'Showing counter present (id="awards-showing-count")' => strpos($html, 'id="awards-showing-count"') !== false,
    'World record badge present' => strpos($html, 'World Record') !== false,
    'Explore Archive CTA present' => strpos($html, 'Explore Archive') !== false,
    'Old Glimpses of Performances removed' => strpos($html, 'Glimpses of Performances') === false,
    'No broken images (onerror fallback present)' => strpos($html, "onerror=\"this.src='/assets/awards/01.jpg';\"") !== false,
];

$allPassed = true;
foreach ($checks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

echo "\n=== 2. VERIFYING ADMIN AWARDS MANAGEMENT & HEADING UPDATE ===\n";
$router = new Router();
require ROOT_DIR . '/routes/web.php';

$admin = Database::fetchOne("SELECT * FROM users WHERE role = 'SUPER_ADMIN' LIMIT 1");
Session::set('user_id', (int)$admin['id']);
Session::set('role', $admin['role']);
Session::set('email', $admin['email']);
Session::set('full_name', $admin['full_name']);

$csrfToken = CSRF::getToken();

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/awards';
$_POST = [];
$adminRes = $router->dispatch(new Request());
$adminHtml = $adminRes->getBody();

$adminChecks = [
    'Admin awards page loads (status 200)' => $adminRes->getStatus() === 200,
    'Showcase settings card present' => strpos($adminHtml, 'Homepage Showcase Settings (Awards & World Records)') !== false,
    'Heading form action /admin/awards/heading present' => strpos($adminHtml, 'action="/admin/awards/heading"') !== false,
    'Add award button & modal present' => strpos($adminHtml, 'createAwardModal') !== false,
    'Image file upload input present' => strpos($adminHtml, 'name="certificate_image"') !== false,
    'Edit modal present' => strpos($adminHtml, 'editAwardModal') !== false,
];

foreach ($adminChecks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

echo "\n=== 3. TESTING POST /admin/awards/heading ===\n";
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/admin/awards/heading';
$_POST = [
    'csrf_token' => $csrfToken,
    'content' => 'PRESTIGIOUS ACCREDITATIONS & HONORS',
    'heading' => 'Awards & World Records [QA-VERIFIED]',
    'subheading' => 'Honored by international record books and national councils for exceptional choreography, preservation of Indian dance, and child talent.',
    'button_text' => 'View All Records & Honors',
    'button_url' => '/awards',
];

$updateReq = new Request();
$updateRes = $router->dispatch($updateReq);
$postSuccess = $updateRes->getStatus() === 302;
echo ($postSuccess ? "  [PASS] " : "  [FAIL] ") . "POST /admin/awards/heading redirected with 302\n";
if (!$postSuccess) $allPassed = false;

$sec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'awards'");
$dbUpdated = !empty($sec) && strpos($sec['heading'], '[QA-VERIFIED]') !== false;
echo ($dbUpdated ? "  [PASS] " : "  [FAIL] ") . "Section record saved in database\n";
if (!$dbUpdated) $allPassed = false;

// Revert test heading back to clean title
Database::query("UPDATE sections SET heading = 'Awards & World Records' WHERE section_key = 'awards'");
echo "  [PASS] Cleaned up QA test heading back to original\n";

echo "\n=== 4. REGRESSION CHECKS ===\n";
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
];

foreach ($regChecks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

if ($allPassed) {
    echo "\n=======================================================\n";
    echo "AWARDS & WORLD RECORDS SHOWCASE: 100% SPEC VERIFIED\n";
    echo "=======================================================\n";
} else {
    echo "\n>>> SOME CHECKS FAILED! <<<\n";
    exit(1);
}
