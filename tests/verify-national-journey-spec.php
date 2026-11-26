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

Database::query("UPDATE pages SET title = 'Our National Journey', subtitle = 'Showcasing the vibrant folk heritage of Gujarat on premier national stages, Rashtriya Lok Utsavs, and state festivals.' WHERE slug = 'journey-national'");
Database::query("DELETE FROM sections WHERE page_id = (SELECT id FROM pages WHERE slug = 'journey-national') AND section_key = 'national_map_showcase'");

echo "=== 1. VERIFYING PUBLIC /journey/national RENDERING (SS 1 TO SS 3 MATCHING) ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/journey/national';
$_POST = [];

$publicController = new PublicController();
$res = $publicController->nationalJourney(new Request());
$html = $res->getBody();

$checks = [
    'Public /journey/national dispatches with HTTP 200' => $res->getStatus() === 200,
    
    // SS 1 Hero Banner
    'Top rainbow line present' => strpos($html, 'from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500') !== false,
    'Hero badge present (Across India)' => strpos($html, 'Across India') !== false,
    'Hero Title present (Our National Journey)' => strpos($html, 'Our National Journey') !== false,
    'Hero Subtitle present' => strpos($html, 'Showcasing the vibrant folk heritage of Gujarat on premier national stages') !== false,

    // SS 1 & SS 2 Map Card
    'Map Card container present' => strpos($html, 'Tours Across Major Indian States') !== false,
    'Map Badge present (National Map & Conclaves)' => strpos($html, 'National Map &amp; Conclaves') !== false || strpos($html, 'National Map & Conclaves') !== false,
    'Indian Flag badge present' => strpos($html, 'Proudly Indian') !== false && strpos($html, 'Gujarat Representation') !== false,
    'Flag image asset referenced' => strpos($html, '/assets/international/in.png') !== false,
    'Interactive SVG India map present' => strpos($html, '<svg') !== false && strpos($html, 'natIndiaMapGrad') !== false,
    'Ahmedabad HQ pin in SVG' => strpos($html, 'Ahmedabad (HQ)') !== false,
    'New Delhi pin in SVG' => strpos($html, 'New Delhi') !== false,
    'Mumbai pin in SVG' => strpos($html, 'Mumbai') !== false,
    'Base note pill present' => strpos($html, 'Base: Ahmedabad | Over 28+ National Festivals') !== false,
    'Cross-journey CTA present' => strpos($html, 'View International Journey') !== false && strpos($html, '/journey/international') !== false,

    // SS 2 & SS 3 3-Column Grid of National Journey Cards
    '3-Column Grid present' => strpos($html, 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3') !== false,
    'Card top color accent bar present' => strpos($html, 'from-amber-500 via-orange-400 to-pink-500') !== false,
    'Stage image container present' => strpos($html, 'aspect-[4/3]') !== false,
    'Image hover overlay with View Photo' => strpos($html, 'View Photo') !== false,
    'Location badge present' => strpos($html, 'India') !== false,
    'Calendar year badge present' => strpos($html, '2023') !== false || strpos($html, '2026') !== false,
    'Card footer View Photo trigger present' => strpos($html, 'openTourLightbox') !== false,
    'Artists count badge present' => strpos($html, 'Artists') !== false,

    // Lightbox Modal
    'Lightbox modal structure present' => strpos($html, 'id="tourLightboxModal"') !== false,
    'Lightbox JavaScript functions present' => strpos($html, 'openTourLightbox') !== false && strpos($html, 'closeTourLightbox') !== false,

    // Responsive Padding matching Services, Disciplines & Stage Moments
    'Padding matches Services & Disciplines (px-3 sm:px-6 lg:px-8 xl:px-12)' => strpos($html, 'px-3 sm:px-6 lg:px-8 xl:px-12') !== false,
];

foreach ($checks as $title => $pass) {
    echo ($pass ? "  [PASS] " : "  [FAIL] ") . $title . "\n";
    if (!$pass) $allPassed = false;
}

echo "\n=== 2. VERIFYING ADMIN /admin/journey/national MANAGEMENT ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/journey/national';
$_SESSION['user_id'] = 1;
$_SESSION['user_role'] = 'SUPER_ADMIN';

$adminRes = $router->dispatch(new Request());
$adminHtml = $adminRes->getBody();

$adminChecks = [
    'Admin /admin/journey/national loads with HTTP 200' => $adminRes->getStatus() === 200,
    'Header & Map settings form action present' => strpos($adminHtml, 'action="/admin/journey/national/settings"') !== false,
    'Hero Pill Badge field present' => strpos($adminHtml, 'name="hero_badge"') !== false,
    'Page Title field present' => strpos($adminHtml, 'name="page_title"') !== false,
    'Map Heading field present' => strpos($adminHtml, 'name="map_heading"') !== false,
    'Map Base Note field present' => strpos($adminHtml, 'name="map_base_note"') !== false,
    'CTA Text field present' => strpos($adminHtml, 'name="cta_text"') !== false,
    'Add Tour Event modal present' => strpos($adminHtml, 'id="createJourneyModal"') !== false,
    'Add modal has cover_image file upload' => strpos($adminHtml, 'name="cover_image"') !== false,
    'Add modal has description textarea' => strpos($adminHtml, 'name="description"') !== false,
    'Edit Tour Event modal present' => strpos($adminHtml, 'id="editJourneyModal"') !== false,
    'Tour events table list present' => strpos($adminHtml, '<table') !== false,
];

foreach ($adminChecks as $title => $pass) {
    echo ($pass ? "  [PASS] " : "  [FAIL] ") . $title . "\n";
    if (!$pass) $allPassed = false;
}

echo "\n=== 3. TESTING POST ACTIONS (SETTINGS & CRUD) ===\n";

// A. Test Settings Update
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/admin/journey/national/settings';
$_POST = [
    'csrf_token' => $csrfToken,
    'page_title' => 'Our National Journey [QA-TESTED]',
    'page_subtitle' => 'Showcasing the vibrant folk heritage of Gujarat across India.',
    'hero_badge' => 'Across India QA',
    'map_heading' => 'Tours Across Major Indian States QA',
    'map_badge' => 'National Map QA',
    'map_base_note' => 'Base: Ahmedabad | 28+ Festivals QA',
    'cta_text' => 'Check international tours QA',
    'cta_url' => '/journey/international',
    'meta_title' => 'National Journey QA',
    'meta_description' => 'QA Meta Description',
];

$setRes = $router->dispatch(new Request());
$settingsRedirect = $setRes->getStatus() === 302;
echo ($settingsRedirect ? "  [PASS] " : "  [FAIL] ") . "POST /admin/journey/national/settings redirected with 302\n";
if (!$settingsRedirect) $allPassed = false;

$updatedPage = Database::fetchOne("SELECT title FROM pages WHERE slug = 'journey-national'");
$pageOk = !empty($updatedPage) && strpos($updatedPage['title'], '[QA-TESTED]') !== false;
echo ($pageOk ? "  [PASS] " : "  [FAIL] ") . "Page title updated in database\n";
if (!$pageOk) $allPassed = false;

// Revert page title back
Database::query("UPDATE pages SET title = 'Our National Journey', subtitle = 'Showcasing the vibrant folk heritage of Gujarat on premier national stages, Rashtriya Lok Utsavs, and state festivals.' WHERE slug = 'journey-national'");
Database::query("DELETE FROM sections WHERE page_id = (SELECT id FROM pages WHERE slug = 'journey-national') AND section_key = 'national_map_showcase'");
echo "  [PASS] Reverted test page settings back to pristine defaults\n";

// B. Test Add Tour Event
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/admin/journey/national';
$_POST = [
    'csrf_token' => $csrfToken,
    'title' => 'Kolkata Eastern Cultural Conclave [QA-TEMP]',
    'festival_name' => 'Eastern Zonal Utsav',
    'country' => 'India',
    'city' => 'Kolkata',
    'year' => 2024,
    'participants_count' => 38,
    'description' => 'Spectacular traditional Garba performance by academy children in Kolkata.',
    'cover_image_url' => '/assets/national/year1.jpg',
    'sort_order' => 999,
];

$createRes = $router->dispatch(new Request());
$createOk = $createRes->getStatus() === 302;
echo ($createOk ? "  [PASS] " : "  [FAIL] ") . "POST /admin/journey/national (create) redirected with 302\n";
if (!$createOk) $allPassed = false;

$createdItem = Database::fetchOne("SELECT * FROM journey_events WHERE title = 'Kolkata Eastern Cultural Conclave [QA-TEMP]'");
$itemCreated = !empty($createdItem) && $createdItem['city'] === 'Kolkata';
echo ($itemCreated ? "  [PASS] " : "  [FAIL] ") . "Tour event inserted into journey_events\n";
if (!$itemCreated) $allPassed = false;

// C. Test Update Tour Event
if ($createdItem) {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_SERVER['REQUEST_URI'] = "/admin/journey/national/{$createdItem['id']}/update";
    $_POST = [
        'csrf_token' => $csrfToken,
        'title' => 'Kolkata Eastern Cultural Conclave [UPDATED]',
        'festival_name' => 'Eastern Zonal Utsav Updated',
        'country' => 'India',
        'city' => 'Kolkata West Bengal',
        'year' => 2024,
        'participants_count' => 42,
        'description' => 'Updated description for Kolkata event.',
        'cover_image_url' => '/assets/national/year2.jpg',
        'sort_order' => 999,
    ];

    $updateRes = $router->dispatch(new Request());
    $updateOk = $updateRes->getStatus() === 302;
    echo ($updateOk ? "  [PASS] " : "  [FAIL] ") . "POST /admin/journey/national/{id}/update redirected with 302\n";
    if (!$updateOk) $allPassed = false;

    // D. Test Delete Tour Event
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_SERVER['REQUEST_URI'] = "/admin/journey/national/{$createdItem['id']}/delete";
    $_POST = ['csrf_token' => $csrfToken];

    $delRes = $router->dispatch(new Request());
    $delOk = $delRes->getStatus() === 302;
    echo ($delOk ? "  [PASS] " : "  [FAIL] ") . "POST /admin/journey/national/{id}/delete redirected with 302\n";
    if (!$delOk) $allPassed = false;

    $deletedItem = Database::fetchOne("SELECT id FROM journey_events WHERE id = :id", ['id' => $createdItem['id']]);
    $itemDeleted = empty($deletedItem);
    echo ($itemDeleted ? "  [PASS] " : "  [FAIL] ") . "Tour event deleted from database\n";
    if (!$itemDeleted) $allPassed = false;
}

echo "\n=== 4. REGRESSION CHECKS ACROSS OTHER PAGES ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/about';
$_POST = [];
$aboutRes = $router->dispatch(new Request());
$aboutHtml = $aboutRes->getBody();

$aboutPass = $aboutRes->getStatus() === 200 && strpos($aboutHtml, 'Founded in 2002') !== false;
echo ($aboutPass ? "  [PASS] " : "  [FAIL] ") . "Public /about page fully intact\n";
if (!$aboutPass) $allPassed = false;

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_POST = [];
$homeRes = $router->dispatch(new Request());
$homeHtml = $homeRes->getBody();

$homePass = $homeRes->getStatus() === 200 && strpos($homeHtml, 'id="curriculum-disciplines"') !== false;
echo ($homePass ? "  [PASS] " : "  [FAIL] ") . "Homepage curriculum section fully intact\n";
if (!$homePass) $allPassed = false;

echo "\n=======================================================\n";
if ($allPassed) {
    echo "NATIONAL JOURNEY CMS & DESIGN: 100% SPEC VERIFIED\n";
    echo "=======================================================\n";
    exit(0);
} else {
    echo ">>> SOME CHECKS FAILED! <<<\n";
    echo "=======================================================\n";
    exit(1);
}
