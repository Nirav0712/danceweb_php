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
use App\Core\Database;
use App\Controllers\PublicController;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');

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

echo "Starting Themed Footer Verification Spec (Screenshot Matching)...\n\n";

// 1. Verify Footer Rendering on Public Page
echo "--- 1. Testing Footer Content & Markup (/about) ---\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/about';
$publicCtrl = new PublicController();
$req = new Request();
$resp = $publicCtrl->about($req);
$html = $resp->getContent();

// Column 1: Brand & Logo
assertCondition(strpos($html, 'src="/logodance.png"') !== false, "Footer renders official academy logo");
assertCondition(strpos($html, 'Premier dance academy dedicated to excellence in dance education since 2005') !== false, "Footer renders brand intro paragraph matching screenshot");

// Column 2: Quick Links
assertCondition(strpos($html, 'QUICK LINKS') !== false, "Footer contains 'QUICK LINKS' header");
assertCondition(strpos($html, '→</span>') !== false || strpos($html, '→') !== false, "Quick links feature arrows");
assertCondition(strpos($html, 'href="/about"') !== false, "Quick links includes About Us");
assertCondition(strpos($html, 'href="/gallery"') !== false, "Quick links includes Gallery");
assertCondition(strpos($html, 'href="/journey/national"') !== false, "Quick links includes National");
assertCondition(strpos($html, 'href="/journey/international"') !== false, "Quick links includes International");
assertCondition(strpos($html, 'href="/blog"') !== false, "Quick links includes Blogs");
assertCondition(strpos($html, 'href="/contact"') !== false, "Quick links includes Contact Us");

// Column 3: Dance Forms
assertCondition(strpos($html, 'DANCE FORMS') !== false, "Footer contains 'DANCE FORMS' header");
assertCondition(strpos($html, 'Bollywood') !== false, "Dance forms includes Bollywood");
assertCondition(strpos($html, 'Folk Dance') !== false, "Dance forms includes Folk Dance");
assertCondition(strpos($html, 'Contemporary') !== false, "Dance forms includes Contemporary");
assertCondition(strpos($html, 'Patriotic') !== false, "Dance forms includes Patriotic");
assertCondition(strpos($html, 'Religious') !== false, "Dance forms includes Religious");
assertCondition(strpos($html, 'Western') !== false, "Dance forms includes Western");

// Column 4: Class Timings
assertCondition(strpos($html, 'CLASS TIMINGS') !== false, "Footer contains 'CLASS TIMINGS' header");
assertCondition(strpos($html, 'Weekdays') !== false && strpos($html, '7 AM - 9 PM') !== false, "Class timings has Weekdays: 7 AM - 9 PM");
assertCondition(strpos($html, 'Weekends') !== false && strpos($html, '8 AM - 8 PM') !== false, "Class timings has Weekends: 8 AM - 8 PM");

// Column 5 & 6: Get in Touch (Nikol & Bapunagar)
assertCondition(strpos($html, 'GET IN TOUCH') !== false, "Footer contains 'GET IN TOUCH' headers");
assertCondition(strpos($html, 'VAIKUNTH COMPLEX, NR. RASPAN ARCADE, NIKOL.') !== false, "Footer contains Nikol campus address");
assertCondition(strpos($html, '204, CENTRE POINT, INDIA COLONY ROAD, BAPUNAGAR.') !== false, "Footer contains Bapunagar campus address");
assertCondition(strpos($html, 'href="tel:+919173878750"') !== false, "Footer contains clickable primary phone link");
assertCondition(strpos($html, 'href="tel:+917228053232"') !== false, "Footer contains clickable secondary phone link");
assertCondition(strpos($html, 'href="mailto:dynamicechildrenacademy@gmail.com"') !== false, "Footer contains clickable email link");
assertCondition(strpos($html, 'https://www.instagram.com/dynamice_children_academy/') !== false, "Footer contains social Instagram link");
assertCondition(strpos($html, 'https://www.youtube.com/@dynamicechildrenacademy') !== false, "Footer contains social YouTube link");

// Upper Row Subscribe Symbol & Modal Popup
assertCondition(strpos($html, 'openNewsletterModal()') !== false, "Footer upper row contains Subscribe symbol trigger button");
assertCondition(strpos($html, 'id="newsletterModal"') !== false, "Footer contains newsletter modal popup element");
assertCondition(strpos($html, 'Subscribe</h3>') !== false, "Newsletter modal contains Subscribe heading");
assertCondition(strpos($html, 'Get updates on new courses') !== false, "Newsletter modal contains 'Get updates on new courses' text");
assertCondition(strpos($html, 'placeholder="Your email address"') !== false, "Newsletter modal contains email input");
assertCondition(strpos($html, 'footerNewsletterForm') !== false, "Newsletter modal contains ajax subscription form");

// Bottom Bar
assertCondition(strpos($html, 'Dynamice Children Academy. All rights reserved.') !== false, "Footer contains copyright line");
assertCondition(strpos($html, 'Made with') !== false && strpos($html, 'by Dynamice Team') !== false, "Footer contains 'Made with ❤️ by Dynamice Team'");
assertCondition(strpos($html, 'href="/privacy-policy"') !== false, "Footer contains Privacy Policy link");
assertCondition(strpos($html, 'href="/terms"') !== false, "Footer contains Terms of Service link");
assertCondition(strpos($html, 'href="/refund-policy"') === false, "Footer bottom bar has Refund Policy removed as requested");

// Container Padding & Iridescent Line
assertCondition(strpos($html, 'w-full px-3 sm:px-6 lg:px-8 xl:px-12') !== false, "Footer uses exact responsive padding matching website sections");
assertCondition(strpos($html, 'bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500') !== false, "Footer top has theme iridescent rainbow line");

// 2. Verify Legal Policy Pages Render Cleanly (Clickable & Working)
echo "\n--- 2. Testing Legal Pages Render Cleanly ---\n";
$privacyResp = $publicCtrl->customPage(new Request(), ['slug' => 'privacy-policy']);
assertCondition($privacyResp->getStatus() === 200, "/privacy-policy renders with HTTP 200");

$termsResp = $publicCtrl->customPage(new Request(), ['slug' => 'terms']);
assertCondition($termsResp->getStatus() === 200, "/terms renders with HTTP 200");

$refundResp = $publicCtrl->customPage(new Request(), ['slug' => 'refund-policy']);
assertCondition($refundResp->getStatus() === 200, "/refund-policy renders with HTTP 200");

// 3. Verify Newsletter Subscribe Endpoint
echo "\n--- 3. Testing Newsletter Subscription API ---\n";
$testSubEmail = "newsletter" . time() . "@example.com";
$subReq = new Request([], ['email' => $testSubEmail], ['REQUEST_METHOD' => 'POST', 'HTTP_ACCEPT' => 'application/json']);
$subResp = $publicCtrl->subscribeNewsletter($subReq);
$subJson = json_decode($subResp->getContent(), true);

assertCondition($subJson !== null && ($subJson['success'] ?? false) === true, "Newsletter subscription endpoint returns success JSON");
$savedSub = Database::fetchOne("SELECT * FROM newsletter_subscribers WHERE email = :e", ['e' => $testSubEmail]);
assertCondition($savedSub !== null, "Newsletter subscriber saved in database");

echo "\n============================================\n";
echo "Total Passes: {$passes}\n";
echo "Total Errors: " . count($errors) . "\n";
if (empty($errors)) {
    echo "ALL FOOTER SPEC TESTS PASSED! 100% SUCCESS\n";
    exit(0);
} else {
    echo "FAILURES ENCOUNTERED:\n";
    foreach ($errors as $e) {
        echo " - {$e}\n";
    }
    exit(1);
}
