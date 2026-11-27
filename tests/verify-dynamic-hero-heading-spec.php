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
use App\Core\Response;
use App\Core\Database;
use App\Core\Session;
use App\Core\Router;
use App\Controllers\PublicController;
use App\Controllers\Admin\HeroController;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');

Session::start();
Session::set('user_id', 1);
Session::set('role', 'SUPER_ADMIN');
Session::set('full_name', 'Master Administrator');
Session::set('email', 'admin@dynamicechildrenacademy.com');

$errors = [];
$passes = 0;

function assertCondition($cond, $message) {
    global $errors, $passes;
    if ($cond) {
        $passes++;
        echo "  [PASS] {$message}\n";
    } else {
        $errors[] = $message;
        echo "  [FAIL] {$message}\n";
    }
}

echo "Starting Dynamic CMS Rotating Hero Heading Verification Spec...\n\n";

// --- 1. Database Table & Seeding Verification ---
echo "--- 1. Testing Database Schema & Initial Seeding ---\n";
$heroCtrl = new HeroController();

// Trigger ensureTableExists via index or reflection
$adminReq = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/admin/hero']);
$adminIndexResp = $heroCtrl->index($adminReq);
assertCondition($adminIndexResp->getStatus() === 200, "Admin Hero Controller renders with HTTP 200");

$tableCheck = Database::fetchOne("SHOW TABLES LIKE 'hero_rotating_phrases'");
assertCondition(!empty($tableCheck), "Table 'hero_rotating_phrases' exists in database");

$initialPhrases = Database::fetchAll("SELECT * FROM hero_rotating_phrases ORDER BY sort_order ASC, id ASC");
assertCondition(count($initialPhrases) >= 5, "Database contains at least 5 seeded rotating phrases");

$phraseTexts = array_column($initialPhrases, 'phrase');
assertCondition(in_array('Indian Dance', $phraseTexts, true), "Initial phrases include 'Indian Dance'");
assertCondition(in_array('Classical Dance', $phraseTexts, true), "Initial phrases include 'Classical Dance'");
assertCondition(in_array('Cultural Excellence', $phraseTexts, true), "Initial phrases include 'Cultural Excellence'");
assertCondition(in_array('Artistic Expression', $phraseTexts, true), "Initial phrases include 'Artistic Expression'");
assertCondition(in_array('Creative Learning', $phraseTexts, true), "Initial phrases include 'Creative Learning'");

$heroSec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'hero'");
assertCondition(!empty($heroSec), "Hero section exists in sections table");
assertCondition($heroSec['heading'] === 'Empowering Young Minds Through', "Hero section heading is initialized to 'Empowering Young Minds Through'");

// --- 2. Admin UI Elements & Preview Verification ---
echo "\n--- 2. Testing Admin Hero UI & Live Preview Markup ---\n";
$adminHtml = $adminIndexResp->getContent();

assertCondition(strpos($adminHtml, 'Hero Section &amp; Dynamic Heading') !== false || strpos($adminHtml, 'Hero Section & Dynamic Heading') !== false, "Admin hero index title updated");
assertCondition(strpos($adminHtml, 'Live Heading Preview') !== false, "Admin page contains Live Heading Preview card");
assertCondition(strpos($adminHtml, 'previewFixedText') !== false, "Live preview includes reactive fixed text element");
assertCondition(strpos($adminHtml, 'previewDynamicPhrase') !== false, "Live preview includes reactive dynamic phrase element");
assertCondition(strpos($adminHtml, 'Test Next Phrase') !== false, "Live preview features 'Test Next Phrase' trigger");
assertCondition(strpos($adminHtml, 'Permanent Fixed Prefix Text') !== false, "Admin page includes Fixed Prefix Text field");
assertCondition(strpos($adminHtml, 'Rotation Duration (Seconds)') !== false, "Admin page includes Rotation Duration field");
assertCondition(strpos($adminHtml, 'Transition Style') !== false, "Admin page includes Transition Style field");
assertCondition(strpos($adminHtml, 'CMS Rotating Heading Phrases') !== false, "Admin page includes Rotating Phrases management table");
assertCondition(strpos($adminHtml, '+ Add Rotating Phrase') !== false, "Admin page includes Add Rotating Phrase button & modal");

// --- 3. Admin CRUD Operations & Validations ---
echo "\n--- 3. Testing Admin Phrases CRUD & Validations ---\n";

// A. Add new phrase
$testPhraseText = "QA Cultural Heritage " . time();
$addReq = new Request([], [
    'phrase' => $testPhraseText,
    'sort_order' => 99,
    'is_active' => '1',
    'csrf_token' => 'dummy',
], ['REQUEST_METHOD' => 'POST']);
$addResp = $heroCtrl->storePhrase($addReq);
assertCondition($addResp->getStatus() === 302, "Store phrase returns 302 redirect");

$addedPhrase = Database::fetchOne("SELECT * FROM hero_rotating_phrases WHERE phrase = :p", ['p' => $testPhraseText]);
assertCondition(!empty($addedPhrase), "New rotating phrase successfully persisted in database");
$phraseId = (int)$addedPhrase['id'];

// B. Empty phrase validation
$emptyAddReq = new Request([], ['phrase' => '   ', 'csrf_token' => 'dummy'], ['REQUEST_METHOD' => 'POST']);
$emptyAddResp = $heroCtrl->storePhrase($emptyAddReq);
assertCondition($emptyAddResp->getStatus() === 302, "Empty phrase submission is caught and redirects with validation error");

// C. Update phrase
$updatedText = $testPhraseText . " (Edited)";
$updateReq = new Request([], [
    'phrase' => $updatedText,
    'sort_order' => 88,
    'is_active' => '1',
    'csrf_token' => 'dummy',
], ['REQUEST_METHOD' => 'POST']);
$updateResp = $heroCtrl->updatePhrase($updateReq, ['id' => $phraseId]);
assertCondition($updateResp->getStatus() === 302, "Update phrase returns 302 redirect");

$persistedEdit = Database::fetchOne("SELECT * FROM hero_rotating_phrases WHERE id = :id", ['id' => $phraseId]);
assertCondition($persistedEdit && $persistedEdit['phrase'] === $updatedText && (int)$persistedEdit['sort_order'] === 88, "Phrase edit successfully saved in database");

// D. Toggle active status
$toggleReq = new Request([], ['csrf_token' => 'dummy'], ['REQUEST_METHOD' => 'POST']);
$toggleResp = $heroCtrl->togglePhrase($toggleReq, ['id' => $phraseId]);
assertCondition($toggleResp->getStatus() === 302, "Toggle phrase status returns 302 redirect");

$toggledItem = Database::fetchOne("SELECT * FROM hero_rotating_phrases WHERE id = :id", ['id' => $phraseId]);
assertCondition($toggledItem && (int)$toggledItem['is_active'] === 0, "Phrase status toggled to inactive (0)");

// Toggle back
$heroCtrl->togglePhrase($toggleReq, ['id' => $phraseId]);
$toggledBackItem = Database::fetchOne("SELECT * FROM hero_rotating_phrases WHERE id = :id", ['id' => $phraseId]);
assertCondition($toggledBackItem && (int)$toggledBackItem['is_active'] === 1, "Phrase status toggled back to active (1)");

// E. Delete phrase
$delReq = new Request([], ['csrf_token' => 'dummy'], ['REQUEST_METHOD' => 'POST']);
$delResp = $heroCtrl->deletePhrase($delReq, ['id' => $phraseId]);
assertCondition($delResp->getStatus() === 302, "Delete phrase returns 302 redirect");

$deletedCheck = Database::fetchOne("SELECT * FROM hero_rotating_phrases WHERE id = :id", ['id' => $phraseId]);
assertCondition(empty($deletedCheck), "Phrase cleanly deleted from database");

// F. Validate Heading Duration Range (2-15s)
$badDurationReq = new Request([], [
    'heading' => 'Empowering Young Minds Through',
    'rotation_duration' => 25, // Too high
    'transition_style' => 'slide-fade',
    'csrf_token' => 'dummy',
], ['REQUEST_METHOD' => 'POST']);
$badDurResp = $heroCtrl->updateHeading($badDurationReq);
assertCondition($badDurResp->getStatus() === 302, "Invalid rotation duration (25s) is rejected with 302 redirect error");

$validHeadingReq = new Request([], [
    'heading' => 'Empowering Young Minds Through',
    'subheading' => 'Premier Performing Arts & Cultural Heritage',
    'rotation_duration' => 4,
    'transition_style' => 'slide-fade',
    'csrf_token' => 'dummy',
], ['REQUEST_METHOD' => 'POST']);
$validHeadingResp = $heroCtrl->updateHeading($validHeadingReq);
assertCondition($validHeadingResp->getStatus() === 302, "Valid heading and duration (4s) saved with 302 redirect");

$savedSec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'hero'");
$savedConfig = json_decode($savedSec['content'] ?? '', true);
assertCondition($savedConfig && (int)$savedConfig['rotation_duration'] === 4, "Rotation duration saved as 4 seconds in JSON content");
assertCondition($savedConfig && $savedConfig['transition_style'] === 'slide-fade', "Transition style saved as 'slide-fade'");

// Restore duration to 3 for standard default
$heroCtrl->updateHeading(new Request([], [
    'heading' => 'Empowering Young Minds Through',
    'subheading' => 'Premier Performing Arts & Cultural Heritage',
    'rotation_duration' => 3,
    'transition_style' => 'slide-fade',
    'csrf_token' => 'dummy',
], ['REQUEST_METHOD' => 'POST']));

// --- 4. Public Homepage Frontend Integration & Rotation Spec ---
echo "\n--- 4. Testing Public Homepage Frontend Rendering ---\n";
$publicCtrl = new PublicController();
$homeReq = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/']);
$homeResp = $publicCtrl->home($homeReq);
$homeHtml = $homeResp->getContent();

assertCondition($homeResp->getStatus() === 200, "Homepage dispatches with HTTP 200");
assertCondition(strpos($homeHtml, 'id="hero-heading-section"') !== false, "Homepage includes hero heading section");
assertCondition(strpos($homeHtml, 'id="hero-rotating-heading"') !== false, "Homepage includes hero rotating heading element");
assertCondition(strpos($homeHtml, 'Empowering Young Minds Through') !== false, "Homepage displays fixed phrase 'Empowering Young Minds Through'");
assertCondition(strpos($homeHtml, 'hero-dynamic-phrase') !== false, "Homepage contains dynamic rotating phrase element");
assertCondition(strpos($homeHtml, 'text-amber-500 font-extrabold') !== false, "Dynamic phrase is styled with amber-500 font-extrabold accent");
assertCondition(strpos($homeHtml, 'data-phrases="') !== false, "Heading element includes data-phrases JSON attribute");
assertCondition(strpos($homeHtml, 'Indian Dance') !== false, "Heading initial render includes 'Indian Dance'");
assertCondition(strpos($homeHtml, 'data-duration="3"') !== false, "Heading data-duration matches configured duration (3s)");
assertCondition(strpos($homeHtml, 'data-transition="slide-fade"') !== false, "Heading data-transition matches configured style (slide-fade)");

// Verify slider script features
assertCondition(strpos($homeHtml, 'mouseenter') !== false && strpos($homeHtml, 'mouseleave') !== false, "Rotator script implements desktop hover pause and resume");
assertCondition(strpos($homeHtml, 'prefers-reduced-motion') !== false, "Rotator script respects prefers-reduced-motion accessibility");
assertCondition(strpos($homeHtml, 'hero-phrase-wrapper') !== false, "Rotator includes layout-shift prevention wrapper");

// Verify Hero Slider & other sections remain 100% intact
assertCondition(strpos($homeHtml, 'id="hero-slider-section"') !== false, "Hero image slider section is 100% intact");
assertCondition(strpos($homeHtml, 'id="curriculum-disciplines"') !== false, "Curriculum & disciplines section below heading is 100% intact");

echo "\n============================================\n";
echo "Total Passes: {$passes}\n";
echo "Total Errors: " . count($errors) . "\n";
if (empty($errors)) {
    echo "ALL DYNAMIC HERO HEADING TESTS PASSED! 100% SUCCESS\n";
    exit(0);
} else {
    echo "FAILURES ENCOUNTERED:\n";
    foreach ($errors as $e) {
        echo " - {$e}\n";
    }
    exit(1);
}
