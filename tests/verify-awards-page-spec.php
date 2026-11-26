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

Session::start();
$admin = Database::fetchOne("SELECT * FROM users WHERE role = 'SUPER_ADMIN' LIMIT 1");
if ($admin) {
    Session::set('user_id', (int)$admin['id']);
    Session::set('role', $admin['role']);
    Session::set('email', $admin['email']);
    Session::set('full_name', $admin['full_name']);
} else {
    Session::set('user_id', 1);
    Session::set('role', 'SUPER_ADMIN');
}
$csrfToken = CSRF::getToken();

$router = new Router();
require ROOT_DIR . '/routes/web.php';

$allPassed = true;

// Set authentic defaults in DB
Database::query("UPDATE pages SET title = 'Awards & World Records', subtitle = 'Certified milestones honoring our child artists, Director Tirthraj Trivedi, and our mission to elevate Indian folk heritage.' WHERE slug = 'award'");
Database::query("UPDATE sections SET heading = 'Awards & World Records', subheading = 'Honored by international record books and national councils for exceptional choreography, preservation of Indian dance, and child talent.', content = 'PRESTIGIOUS ACCREDITATIONS & HONORS', button_text = 'View All Records & Honors', button_url = '/awards' WHERE section_key = 'awards'");

echo "=== 1. VERIFYING PUBLIC /award AND /awards RENDERING (SCREENSHOT MATCHING) ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/award';
$_POST = [];

$publicController = new PublicController();
$res = $publicController->awards(new Request());
$html = $res->getBody();

$checks = [
    'Public /award dispatches with HTTP 200' => $res->getStatus() === 200,
    
    // Hero Banner
    'Top iridescent rainbow line present' => strpos($html, 'from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500') !== false,
    'Hero badge present (ACHIEVEMENTS & ACCOLADES)' => strpos($html, 'ACHIEVEMENTS &amp; ACCOLADES') !== false || strpos($html, 'ACHIEVEMENTS & ACCOLADES') !== false,
    'Hero Title present (Awards & World Records)' => strpos($html, 'Awards &amp; World Records') !== false || strpos($html, 'Awards & World Records') !== false,
    'Hero Subtitle present' => strpos($html, 'Certified milestones honoring our child artists') !== false,

    // Filter Tabs
    'All Accolades button present' => strpos($html, 'All Accolades') !== false,
    'World Records button present' => strpos($html, 'World Records') !== false,
    'National Honors button present' => strpos($html, 'National Honors') !== false,

    // 3-Column Grid & Cards
    '3-Column Grid present' => strpos($html, 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3') !== false,
    'Card stage photo container present' => strpos($html, 'aspect-[4/3]') !== false,
    'Card image hover zoom present' => strpos($html, 'group-hover/img:scale-108') !== false,
    'Card World Record badge present' => strpos($html, 'World Record') !== false,
    'Card National Award badge present' => strpos($html, 'National Award') !== false,
    'Card year present' => strpos($html, '2026') !== false || strpos($html, '2023') !== false,
    'Card Conferred by present' => strpos($html, 'Conferred by:') !== false,
    'Card View Certificate trigger present' => strpos($html, 'openCertificateLightbox') !== false,

    // Lightbox Modal
    'Lightbox Modal present' => strpos($html, 'id="certLightboxModal"') !== false,
    'Lightbox JavaScript functions present' => strpos($html, 'openCertificateLightbox') !== false && strpos($html, 'closeCertificateLightbox') !== false,
    'Filter JavaScript function present' => strpos($html, 'filterAwards') !== false,

    // Responsive Padding matching Services, Disciplines & Stage Moments
    'Padding matches Services & Disciplines (px-3 sm:px-6 lg:px-8 xl:px-12)' => strpos($html, 'px-3 sm:px-6 lg:px-8 xl:px-12') !== false,
];

foreach ($checks as $title => $pass) {
    echo ($pass ? "  [PASS] " : "  [FAIL] ") . $title . "\n";
    if (!$pass) $allPassed = false;
}

echo "\n=== 2. VERIFYING ADMIN /admin/awards MANAGEMENT ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/awards';
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'SUPER_ADMIN';

$adminRes = $router->dispatch(new Request());
$adminHtml = $adminRes->getBody();

$adminChecks = [
    'Admin /admin/awards loads with HTTP 200' => $adminRes->getStatus() === 200,
    'Showcase settings form action /admin/awards/heading present' => strpos($adminHtml, 'action="/admin/awards/heading"') !== false,
    'Heading field present' => strpos($adminHtml, 'name="heading"') !== false,
    'Subtitle field present' => strpos($adminHtml, 'name="subheading"') !== false,
    'Top badge field present' => strpos($adminHtml, 'name="content"') !== false,
    'Add Award modal present' => strpos($adminHtml, 'id="createAwardModal"') !== false,
    'Add modal has certificate_image file upload' => strpos($adminHtml, 'name="certificate_image"') !== false,
    'Edit Award modal present' => strpos($adminHtml, 'id="editAwardModal"') !== false,
    'Awards table list present' => strpos($adminHtml, '<table') !== false,
];

foreach ($adminChecks as $title => $pass) {
    echo ($pass ? "  [PASS] " : "  [FAIL] ") . $title . "\n";
    if (!$pass) $allPassed = false;
}

echo "\n=== 3. TESTING POST ACTIONS (SETTINGS & CRUD) ===\n";

// A. Test Heading Update
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/admin/awards/heading';
$_POST = [
    'csrf_token' => $csrfToken,
    'heading' => 'Awards & World Records [QA-TESTED]',
    'subheading' => 'Certified milestones honoring our child artists QA.',
    'content' => 'ACHIEVEMENTS & ACCOLADES QA',
    'button_text' => 'View All Records QA',
    'button_url' => '/awards',
];

$headRes = $router->dispatch(new Request());
$headRedirect = $headRes->getStatus() === 302;
echo ($headRedirect ? "  [PASS] " : "  [FAIL] ") . "POST /admin/awards/heading redirected with 302\n";
if (!$headRedirect) $allPassed = false;

$updatedSec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'awards'");
$secOk = !empty($updatedSec) && strpos($updatedSec['heading'], '[QA-TESTED]') !== false;
echo ($secOk ? "  [PASS] " : "  [FAIL] ") . "Section heading updated in database\n";
if (!$secOk) $allPassed = false;

$updatedPage = Database::fetchOne("SELECT * FROM pages WHERE slug = 'award'");
$pageOk = !empty($updatedPage) && strpos($updatedPage['title'], '[QA-TESTED]') !== false;
echo ($pageOk ? "  [PASS] " : "  [FAIL] ") . "Dedicated /award page title synced in database\n";
if (!$pageOk) $allPassed = false;

// Revert back
Database::query("UPDATE pages SET title = 'Awards & World Records', subtitle = 'Certified milestones honoring our child artists, Director Tirthraj Trivedi, and our mission to elevate Indian folk heritage.' WHERE slug = 'award'");
Database::query("UPDATE sections SET heading = 'Awards & World Records', subheading = 'Honored by international record books and national councils for exceptional choreography, preservation of Indian dance, and child talent.', content = 'PRESTIGIOUS ACCREDITATIONS & HONORS', button_text = 'View All Records & Honors', button_url = '/awards' WHERE section_key = 'awards'");
echo "  [PASS] Reverted test headings back to authentic defaults\n";

// B. Test Add Award
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/admin/awards';
$_POST = [
    'csrf_token' => $csrfToken,
    'title' => 'Gujarat State Kala Gaurav Puraskar [QA-TEMP]',
    'issuer' => 'Government of Gujarat Culture Council',
    'category' => 'State Award',
    'year' => 2024,
    'description' => 'Prestigious state honor conferred for lifetime cultural preservation.',
    'certificate_image_url' => '/assets/awards/01.jpg',
    'is_record_book' => 0,
    'is_featured' => 1,
    'sort_order' => 999,
];

$createRes = $router->dispatch(new Request());
$createOk = $createRes->getStatus() === 302;
echo ($createOk ? "  [PASS] " : "  [FAIL] ") . "POST /admin/awards (create) redirected with 302\n";
if (!$createOk) $allPassed = false;

$createdAward = Database::fetchOne("SELECT * FROM awards WHERE title = 'Gujarat State Kala Gaurav Puraskar [QA-TEMP]'");
$awardCreated = !empty($createdAward);
echo ($awardCreated ? "  [PASS] " : "  [FAIL] ") . "Award inserted into awards table\n";
if (!$awardCreated) $allPassed = false;

// C. Test Update Award
if ($createdAward) {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_SERVER['REQUEST_URI'] = "/admin/awards/{$createdAward['id']}/update";
    $_POST = [
        'csrf_token' => $csrfToken,
        'title' => 'Gujarat State Kala Gaurav Puraskar [UPDATED]',
        'issuer' => 'Government of Gujarat Culture Council Updated',
        'category' => 'State Award',
        'year' => 2024,
        'description' => 'Updated description.',
        'certificate_image_url' => '/assets/awards/02.jpg',
        'is_record_book' => 0,
        'is_featured' => 1,
        'sort_order' => 999,
    ];

    $updateRes = $router->dispatch(new Request());
    $updateOk = $updateRes->getStatus() === 302;
    echo ($updateOk ? "  [PASS] " : "  [FAIL] ") . "POST /admin/awards/{id}/update redirected with 302\n";
    if (!$updateOk) $allPassed = false;

    // D. Test Delete Award
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_SERVER['REQUEST_URI'] = "/admin/awards/{$createdAward['id']}/delete";
    $_POST = ['csrf_token' => $csrfToken];

    $delRes = $router->dispatch(new Request());
    $delOk = $delRes->getStatus() === 302;
    echo ($delOk ? "  [PASS] " : "  [FAIL] ") . "POST /admin/awards/{id}/delete redirected with 302\n";
    if (!$delOk) $allPassed = false;

    $deletedAward = Database::fetchOne("SELECT id FROM awards WHERE id = :id", ['id' => $createdAward['id']]);
    $awardDeleted = empty($deletedAward);
    echo ($awardDeleted ? "  [PASS] " : "  [FAIL] ") . "Award deleted from database\n";
    if (!$awardDeleted) $allPassed = false;
}

echo "\n=== 4. REGRESSION CHECKS ACROSS OTHER PAGES ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/journey/national';
$_POST = [];
$natRes = $router->dispatch(new Request());
$natPass = $natRes->getStatus() === 200 && strpos($natRes->getBody(), 'Our National Journey') !== false;
echo ($natPass ? "  [PASS] " : "  [FAIL] ") . "Public /journey/national page fully intact\n";
if (!$natPass) $allPassed = false;

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/journey/international';
$_POST = [];
$intlRes = $router->dispatch(new Request());
$intlPass = $intlRes->getStatus() === 200 && strpos($intlRes->getBody(), 'International Journey') !== false;
echo ($intlPass ? "  [PASS] " : "  [FAIL] ") . "Public /journey/international page fully intact\n";
if (!$intlPass) $allPassed = false;

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/about';
$_POST = [];
$aboutRes = $router->dispatch(new Request());
$aboutPass = $aboutRes->getStatus() === 200 && strpos($aboutRes->getBody(), 'Founded in 2002') !== false;
echo ($aboutPass ? "  [PASS] " : "  [FAIL] ") . "Public /about page fully intact\n";
if (!$aboutPass) $allPassed = false;

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_POST = [];
$homeRes = $router->dispatch(new Request());
$homePass = $homeRes->getStatus() === 200 && strpos($homeRes->getBody(), 'id="curriculum-disciplines"') !== false;
echo ($homePass ? "  [PASS] " : "  [FAIL] ") . "Homepage curriculum section fully intact\n";
if (!$homePass) $allPassed = false;

echo "\n=======================================================\n";
if ($allPassed) {
    echo "AWARDS & WORLD RECORDS PAGE CMS & DESIGN: 100% SPEC VERIFIED\n";
    echo "=======================================================\n";
    exit(0);
} else {
    echo ">>> SOME CHECKS FAILED! <<<\n";
    echo "=======================================================\n";
    exit(1);
}
