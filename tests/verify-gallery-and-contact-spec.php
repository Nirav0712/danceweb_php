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
use App\Controllers\Admin\GalleryController;
use App\Controllers\Admin\BranchesController;

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

echo "Starting Gallery and Contact Spec Verification...\n\n";

// Print describe website_settings
$cols = Database::fetchAll("DESCRIBE website_settings");
echo "website_settings columns: " . implode(', ', array_column($cols, 'Field')) . "\n";
echo "--- 1. Testing Public Gallery Page (/gallery) ---\n";
ob_start();
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/gallery';
$publicCtrl = new PublicController();
$request = new Request();
$response = $publicCtrl->gallery($request);
$output = $response->getContent();
ob_end_clean();

// Check what H1 was rendered
preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $output, $h1Match);
$h1Text = trim(strip_tags($h1Match[1] ?? ''));
echo "  Found Gallery H1: '{$h1Text}'\n";

assertCondition(strpos($output, 'VISUAL ARCHIVE') !== false, "Gallery page contains 'VISUAL ARCHIVE' badge");
assertCondition(strpos($output, 'Performance Photo Gallery') !== false || $h1Text === 'Performance Photo Gallery', "Gallery page contains 'Performance Photo Gallery' title");
assertCondition(strpos($output, 'All Photographs') !== false, "Gallery page contains 'All Photographs' filter pill");
assertCondition(strpos($output, 'w-full px-3 sm:px-6 lg:px-8 xl:px-12') !== false, "Gallery page has matching responsive container padding");
assertCondition(strpos($output, 'galleryLightboxModal') !== false, "Gallery page includes interactive lightbox modal");
assertCondition(strpos($output, 'openGalleryLightbox') !== false, "Gallery page includes lightbox trigger handler");

// 2. Verify Public Contact Page
echo "\n--- 2. Testing Public Contact Page (/contact) ---\n";
ob_start();
$_SERVER['REQUEST_URI'] = '/contact';
$responseContact = $publicCtrl->contact($request);
$contactOutput = $responseContact->getContent();
ob_end_clean();

preg_match('/<h1[^>]*>(.*?)<\/h1>/s', $contactOutput, $contactH1Match);
$contactH1Text = trim(strip_tags($contactH1Match[1] ?? ''));
echo "  Found Contact H1: '{$contactH1Text}'\n";

assertCondition(strpos($contactOutput, 'ADMISSIONS &amp; ENQUIRIES') !== false || strpos($contactOutput, 'ADMISSIONS & ENQUIRIES') !== false, "Contact page contains 'ADMISSIONS & ENQUIRIES' badge");
assertCondition(strpos($contactOutput, 'Connect With Our Academy') !== false, "Contact page contains 'Connect With Our Academy' title");
assertCondition(strpos($contactOutput, 'Academy Headquarters') !== false, "Contact page contains 'Academy Headquarters' section");
assertCondition(strpos($contactOutput, 'Send Us an Enquiry') !== false, "Contact page contains 'Send Us an Enquiry' form");
assertCondition(strpos($contactOutput, 'Our Teaching Campuses') !== false, "Contact page lists teaching campuses");
assertCondition(strpos($contactOutput, 'Find Our Studios on Google Maps') !== false, "Contact page has interactive Google Maps studio switcher");
assertCondition(strpos($contactOutput, 'switchMapBranch') !== false, "Contact page has studio map switching JavaScript function");
assertCondition(strpos($contactOutput, 'w-full px-3 sm:px-6 lg:px-8 xl:px-12') !== false, "Contact page has matching responsive container padding");

// 3. Test Enquiry Submission Endpoint
echo "\n--- 3. Testing Enquiry Submission Endpoint (/api/enquiries) ---\n";
$testName = "Test Parent " . time();
$testEmail = "testparent" . time() . "@example.com";
$testPhone = "+91 99999 88888";
$testMsg = "Automated test message for admission inquiry.";

$enquiryData = [
    'csrf_token' => $csrfToken,
    'name' => $testName,
    'email' => $testEmail,
    'phone' => $testPhone,
    'preferred_branch' => 'Nikol Branch (HQ)',
    'subject' => 'New Admission Enquiry',
    'message' => $testMsg,
];

$_POST = $enquiryData;
$_SERVER['HTTP_ACCEPT'] = 'application/json';
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/api/enquiries';

$enquiryRequest = new Request([], $enquiryData, ['HTTP_ACCEPT' => 'application/json', 'REQUEST_METHOD' => 'POST', 'REQUEST_URI' => '/api/enquiries']);
$enquiryResponse = $publicCtrl->submitEnquiry($enquiryRequest);
$json = json_decode($enquiryResponse->getContent(), true);
echo "  submitEnquiry JSON response: " . $enquiryResponse->getContent() . "\n";

assertCondition($json !== null && ($json['success'] ?? false) === true, "submitEnquiry returns success: true JSON");

$savedEnquiry = Database::fetchOne("SELECT * FROM enquiries WHERE email = :email ORDER BY id DESC LIMIT 1", ['email' => $testEmail]);
assertCondition($savedEnquiry !== null && strpos($savedEnquiry['name'], $testName) !== false, "Enquiry was successfully stored in the database with matching student name");

// 4. Test Admin Branches and Contact CMS
echo "\n--- 4. Testing Admin Branches & Contact CMS Settings ---\n";
$adminBranchesCtrl = new BranchesController();
$adminBranchesReq = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/admin/branches']);
$adminBranchesResp = $adminBranchesCtrl->index($adminBranchesReq);
$adminBranchesHtml = $adminBranchesResp->getContent();

assertCondition(strpos($adminBranchesHtml, 'Contact Page Header &amp; Headquarter Info CMS') !== false || strpos($adminBranchesHtml, 'Contact Page Header & Headquarter Info CMS') !== false, "Admin Branches page includes Contact Page Header & Info CMS");
assertCondition(strpos($adminBranchesHtml, 'Campuses &amp; Contact Page CMS') !== false || strpos($adminBranchesHtml, 'Campuses & Contact Page CMS') !== false, "Admin Branches page title updated");

// Test updating settings
$newPhone = '+91 99242 81372';
$updateReq = new Request([], [
    'page_title' => 'Connect With Our Academy',
    'page_subtitle' => 'Have questions about admissions, batch timings, certified diploma courses, or cultural event performances? Reach out to our admissions team.',
    'badge_label' => 'ADMISSIONS & ENQUIRIES',
    'contact_phone' => $newPhone,
    'contact_email' => 'info@dynamicechildrenacademy.com',
    'contact_hours' => 'Monday to Saturday: 8:00 AM - 9:00 PM | Sunday: 8:00 AM - 2:00 PM (Special Batches)',
    'meta_title' => 'Contact & Admissions — Dynamice Children Academy',
    'meta_description' => 'Connect with Dynamice Children Academy admissions in Ahmedabad.',
], ['REQUEST_METHOD' => 'POST', 'REQUEST_URI' => '/admin/branches/settings']);

$updateResp = $adminBranchesCtrl->updateSettings($updateReq);
assertCondition($updateResp->getStatusCode() === 302, "updateSettings redirects back with 302");

$updatedSetting = Database::fetchOne("SELECT setting_value FROM website_settings WHERE setting_key = 'contact_phone'");
assertCondition($updatedSetting !== null && $updatedSetting['setting_value'] === $newPhone, "website_settings table updated with new phone number");

// 5. Test Admin Gallery CMS
echo "\n--- 5. Testing Admin Gallery CMS Settings ---\n";
$adminGalleryCtrl = new GalleryController();
$adminGalleryReq = new Request([], [], ['REQUEST_METHOD' => 'GET', 'REQUEST_URI' => '/admin/gallery']);
$adminGalleryResp = $adminGalleryCtrl->index($adminGalleryReq);
$adminGalleryHtml = $adminGalleryResp->getContent();

assertCondition(strpos($adminGalleryHtml, 'Page Header &amp; Banner CMS Settings') !== false || strpos($adminGalleryHtml, 'Page Header & Banner CMS Settings') !== false || strpos($adminGalleryHtml, '/admin/gallery/settings') !== false, "Admin Gallery page includes Header CMS Settings form");
assertCondition(strpos($adminGalleryHtml, 'Performance Photo Gallery') !== false, "Admin Gallery page lists items and settings");

echo "\n============================================\n";
echo "Total Passes: {$passes}\n";
echo "Total Errors: " . count($errors) . "\n";
if (empty($errors)) {
    echo "ALL TESTS PASSED!\n";
    exit(0);
} else {
    echo "FAILURES ENCOUNTERED:\n";
    foreach ($errors as $e) {
        echo " - {$e}\n";
    }
    exit(1);
}
