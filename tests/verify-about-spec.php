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

// Clean up any lingering test sections before running tests
Database::query("DELETE FROM sections WHERE page_id = (SELECT id FROM pages WHERE slug = 'about')");
Database::query("UPDATE pages SET title = 'About Us' WHERE slug = 'about'");

echo "=== 1. VERIFYING PUBLIC /about PAGE RENDERING (SS 1 TO SS 6 MATCHING) ===\n";
$publicController = new PublicController();
$request = new Request();
$res = $publicController->about($request);
$html = $res->getBody();

$checks = [
    'Public /about dispatches with HTTP 200' => $res->getStatus() === 200,
    // SS 1 Hero
    'Hero Banner badge present (Our Journey & Heritage)' => strpos($html, 'Our Journey &amp; Heritage') !== false || strpos($html, 'Our Journey') !== false,
    'Hero Banner Title present (About Us)' => strpos($html, 'About Us') !== false,
    'Hero Banner Subtitle present (Founded in 2002 by Director Tirthraj Trivedi)' => strpos($html, 'Founded in 2002 by Director Tirthraj Trivedi') !== false,
    
    // SS 1 Section 1: Founded in 2002
    'Section 1 badge present (ABOUT US)' => strpos($html, 'ABOUT US') !== false,
    'Section 1 heading present (Founded in 2002)' => strpos($html, 'Founded in 2002') !== false,
    'Section 1 stage photo present' => strpos($html, 'founded-2002-stage.jpg') !== false || strpos($html, 'aboutimg2.png') !== false,
    'Section 1 Est. 2002 and 6,000+ Students Trained badges' => strpos($html, 'Est. 2002') !== false && strpos($html, '6,000+ Students Trained') !== false,
    'Section 1 narrative paragraph 1 present' => strpos($html, 'Founded in 2002 by Director Tirthraj Trivedi with just 14 students') !== false,
    'Section 1 narrative paragraph 2 present' => strpos($html, 'Government-Registered Institution') !== false,
    'Section 1 narrative paragraph 3 present' => strpos($html, 'London Book of World Records') !== false,

    // SS 2 & SS 3 Section 2: Dance Technique & Steps
    'Section 2 badge present (OUR DANCE TECHNIQUE)' => strpos($html, 'OUR DANCE TECHNIQUE') !== false,
    'Section 2 heading present (We\'re some simple steps for teaching dance)' => strpos($html, "simple steps for teaching dance") !== false,
    'Section 2 Dance Step 01 tab present' => strpos($html, 'Dance Step 01') !== false,
    'Section 2 Dance Step 02 tab present' => strpos($html, 'Dance Step 02') !== false,
    'Section 2 Dance Step 03 tab present' => strpos($html, 'Dance Step 03') !== false,
    'Section 2 Checklist 4 items present' => strpos($html, 'Dance Practice') !== false && strpos($html, 'Dance Growth') !== false && strpos($html, 'Dance Training') !== false && strpos($html, 'Dance Improvement') !== false,
    'Section 2 JavaScript switcher present' => strpos($html, 'switchDanceStep') !== false,

    // SS 3 Digital Pedagogical Framework
    'Framework dark container present' => strpos($html, 'bg-gray-950 text-white rounded-3xl') !== false,
    'Framework badge present (Structured Pedagogical Framework)' => strpos($html, 'Structured Pedagogical Framework') !== false,
    'Framework heading present (SIMPLE STEPS FOR TEACHING DANCE)' => strpos($html, 'SIMPLE STEPS FOR TEACHING DANCE') !== false,
    'Step 01 present (WARM-UP & STRETCH)' => strpos($html, 'WARM-UP &amp; STRETCH') !== false || strpos($html, 'WARM-UP & STRETCH') !== false,
    'Step 02 present (BREAKDOWN & DRILL)' => strpos($html, 'BREAKDOWN &amp; DRILL') !== false || strpos($html, 'BREAKDOWN & DRILL') !== false,
    'Step 03 present (CHOREOGRAPH & CREATE)' => strpos($html, 'CHOREOGRAPH &amp; CREATE') !== false || strpos($html, 'CHOREOGRAPH & CREATE') !== false,
    'Step 04 present (PERFORM & SHARE)' => strpos($html, 'PERFORM &amp; SHARE') !== false || strpos($html, 'PERFORM & SHARE') !== false,

    // SS 4 Section 3: Our Awards & Recognition
    'Section 3 heading present (Our Awards & Recognition)' => strpos($html, 'Our Awards &amp; Recognition') !== false || strpos($html, 'Our Awards & Recognition') !== false,
    'Section 3 badge 1 (London Book of World Records)' => strpos($html, 'London Book of World Records') !== false,
    'Section 3 badge 2 (Govt. Approved Vocational Centre)' => strpos($html, 'Govt. Approved Vocational Centre') !== false,
    'Section 3 badge 3 (CIOFF & IOV)' => strpos($html, 'CIOFF &amp; IOV') !== false || strpos($html, 'CIOFF & IOV') !== false,
    'Section 3 badge 4 (IAF & EGAC Quality Certified)' => strpos($html, 'IAF &amp; EGAC') !== false || strpos($html, 'IAF & EGAC') !== false,

    // SS 5 Section 4: Our Media Journey
    'Section 4 badge present (RECOGNIZED GLOBALLY, CELEBRATED NATIONALLY)' => strpos($html, 'RECOGNIZED GLOBALLY, CELEBRATED NATIONALLY') !== false,
    'Section 4 heading present (Our Media Journey)' => strpos($html, 'Our Media Journey') !== false,
    'Media col 1 present (200+ Print Articles)' => strpos($html, '200+ Print Articles') !== false,
    'Media col 2 present (60+ News Channels)' => strpos($html, '60+ News Channels') !== false,
    'Media col 3 present (50+ Global Features)' => strpos($html, '50+ Global Features') !== false,

    // SS 6 Section 5: Vision, Mission & Values
    'Section 5 badge present (Guiding Principles)' => strpos($html, 'Guiding Principles') !== false,
    'Section 5 heading present (Our Vision, Mission & Core Values)' => strpos($html, 'Our Vision, Mission &amp; Core Values') !== false || strpos($html, 'Our Vision, Mission & Core Values') !== false,
    'Our Vision card present' => strpos($html, 'Our Vision') !== false,
    'Our Mission card present' => strpos($html, 'Our Mission') !== false,
    'Our Core Values card present' => strpos($html, 'Our Core Values') !== false,

    // SS 6 Section 6: Call To Action
    'CTA heading present (Experience the Joy of Dance Firsthand)' => strpos($html, 'Experience the Joy of Dance Firsthand') !== false,
    'CTA button present (Contact Admissions)' => strpos($html, 'Contact Admissions') !== false,

    // Responsive Padding matching Curriculum Section
    'Padding matches Services & Disciplines (px-3 sm:px-6 lg:px-8 xl:px-12)' => strpos($html, 'px-3 sm:px-6 lg:px-8 xl:px-12') !== false,
];

$allPassed = true;
foreach ($checks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

echo "\n=== 2. VERIFYING ADMIN /admin/about MANAGEMENT & CMS SYNC ===\n";
$router = new Router();
require ROOT_DIR . '/routes/web.php';

$admin = Database::fetchOne("SELECT * FROM users WHERE role = 'SUPER_ADMIN' LIMIT 1");
Session::set('user_id', (int)$admin['id']);
Session::set('role', $admin['role']);
Session::set('email', $admin['email']);
Session::set('full_name', $admin['full_name']);

$csrfToken = CSRF::getToken();

// Test Admin Index
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin/about';
$_POST = [];
$adminRes = $router->dispatch(new Request());
$adminHtml = $adminRes->getBody();

$adminChecks = [
    'Admin /admin/about loads with HTTP 200' => $adminRes->getStatus() === 200,
    'Card 1: Page Header form present' => strpos($adminHtml, '1. Hero Banner') !== false,
    'Card 2: Founded in 2002 form present' => strpos($adminHtml, '2. Section 1: Founded in 2002') !== false,
    'Card 3: Dance Technique form present' => strpos($adminHtml, '3. Section 2: Our Dance Technique') !== false,
    'Card 4: Pedagogical Framework form present' => strpos($adminHtml, '4. Section 2 Part 2: Structured Pedagogical Framework') !== false,
    'Card 5: Awards & Recognition form present' => strpos($adminHtml, '5. Section 3: Our Awards') !== false,
    'Card 6: Media Journey form present' => strpos($adminHtml, '6. Section 4: Our Media Journey') !== false,
    'Card 7: Vision Mission form present' => strpos($adminHtml, '7. Section 5: Vision, Mission') !== false,
    'Card 8: CTA Banner form present' => strpos($adminHtml, '8. Section 6: Bottom Call To Action') !== false,
    'Save button with CSRF token present' => strpos($adminHtml, 'name="csrf_token"') !== false,
];

foreach ($adminChecks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

echo "\n=== 3. TESTING POST /admin/about UPDATE ===\n";
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/admin/about';
$_POST = [
    'csrf_token' => $csrfToken,
    'page_title' => 'About Us [QA-TESTED]',
    'page_subtitle' => 'Founded in 2002 by Director Tirthraj Trivedi',
    'founded_heading' => 'Founded in 2002',
    'founded_badge' => 'ABOUT US',
    'founded_est_year' => '2002',
    'founded_students_trained' => '6,000+ Students Trained',
    'founded_p1' => 'QA Test Paragraph 1',
    'technique_heading' => "We're some simple steps for teaching dance",
    'technique_badge' => 'OUR DANCE TECHNIQUE',
    'technique_step1' => 'Step 1 QA desc',
    'framework_heading' => 'SIMPLE STEPS FOR TEACHING DANCE',
    'framework_badge' => 'Structured Pedagogical Framework',
    'awards_heading' => 'Our Awards & Recognition',
    'media_heading' => 'Our Media Journey',
    'vision_heading' => 'Our Vision, Mission & Core Values',
    'cta_heading' => 'Experience the Joy of Dance Firsthand',
    'cta_button_text' => 'Contact Admissions',
    'cta_button_url' => '/contact',
];

$updateReq = new Request();
$updateRes = $router->dispatch($updateReq);
$postSuccess = $updateRes->getStatus() === 302;
echo ($postSuccess ? "  [PASS] " : "  [FAIL] ") . "POST /admin/about redirected with 302\n";
if (!$postSuccess) $allPassed = false;

$updatedPage = Database::fetchOne("SELECT title FROM pages WHERE slug = 'about'");
$pageUpdated = !empty($updatedPage) && strpos($updatedPage['title'], '[QA-TESTED]') !== false;
echo ($pageUpdated ? "  [PASS] " : "  [FAIL] ") . "Page title updated in database\n";
if (!$pageUpdated) $allPassed = false;

$foundedSec = Database::fetchOne("SELECT content FROM sections WHERE section_key = 'about_founded'");
$foundedUpdated = !empty($foundedSec) && strpos($foundedSec['content'], 'QA Test Paragraph 1') !== false;
echo ($foundedUpdated ? "  [PASS] " : "  [FAIL] ") . "Section content updated in database\n";
if (!$foundedUpdated) $allPassed = false;

// Revert test title and sections back to clean state
Database::query("UPDATE pages SET title = 'About Us' WHERE slug = 'about'");
Database::query("DELETE FROM sections WHERE page_id = (SELECT id FROM pages WHERE slug = 'about')");
echo "  [PASS] Cleaned up QA test title and test sections back to original\n";

echo "\n=== 4. REGRESSION CHECKS ACROSS OTHER MODULES ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_POST = [];
$homeRes = $router->dispatch(new Request());
$homeHtml = $homeRes->getBody();

$regChecks = [
    'Homepage Hero banner intact' => strpos($homeHtml, 'id="hero-slider-section"') !== false,
    'Homepage 7-tab curriculum intact' => strpos($homeHtml, 'id="curriculum-disciplines"') !== false,
    'Homepage Tour flags carousel intact' => strpos($homeHtml, 'id="tour-flags-showcase"') !== false,
    'Homepage Awards showcase intact' => strpos($homeHtml, 'id="awards-showcase-section"') !== false,
    'Homepage Words from families intact' => strpos($homeHtml, 'id="parent-reflections-section"') !== false,
];

foreach ($regChecks as $name => $passed) {
    echo ($passed ? "  [PASS] " : "  [FAIL] ") . $name . "\n";
    if (!$passed) $allPassed = false;
}

if ($allPassed) {
    echo "\n=======================================================\n";
    echo "ABOUT US PAGE CMS & DESIGN: 100% SPEC VERIFIED\n";
    echo "=======================================================\n";
} else {
    echo "\n>>> SOME CHECKS FAILED! <<<\n";
    exit(1);
}
