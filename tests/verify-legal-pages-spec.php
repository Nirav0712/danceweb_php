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

echo "Starting Themed Privacy Policy & Terms Pages Verification Spec...\n\n";

$publicCtrl = new PublicController();

// 1. Verify Privacy Policy Page (/privacy-policy)
echo "--- 1. Testing Privacy Policy Page (/privacy-policy) ---\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/privacy-policy';
$privacyResp = $publicCtrl->privacyPolicy(new Request());
$privacyHtml = $privacyResp->getContent();

assertCondition($privacyResp->getStatus() === 200, "Privacy Policy page dispatches with HTTP 200");
assertCondition(strpos($privacyHtml, 'LEGAL COMPLIANCE &amp; STUDENT SAFETY') !== false || strpos($privacyHtml, 'LEGAL COMPLIANCE & STUDENT SAFETY') !== false, "Privacy Policy contains 'LEGAL COMPLIANCE & STUDENT SAFETY' badge");
assertCondition(strpos($privacyHtml, '<h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white mb-4">') !== false && strpos($privacyHtml, 'Privacy Policy') !== false, "Privacy Policy contains main H1 heading");
assertCondition(strpos($privacyHtml, 'Table of Contents') !== false, "Privacy Policy includes quick navigation index");
assertCondition(strpos($privacyHtml, 'Commitment to Child &amp; Family Safety') !== false || strpos($privacyHtml, 'Commitment to Child & Family Safety') !== false, "Section 01 Child Safety present");
assertCondition(strpos($privacyHtml, 'Information We Collect') !== false, "Section 02 Information We Collect present");
assertCondition(strpos($privacyHtml, 'Performance Media Rights') !== false, "Section 03 Performance Media Rights present");
assertCondition(strpos($privacyHtml, 'How We Use Information') !== false, "Section 04 How We Use Information present");
assertCondition(strpos($privacyHtml, 'Anti-Sale Policy') !== false || strpos($privacyHtml, 'Zero Commercial Data Monetization') !== false, "Section 05 Anti-Sale guarantee present");
assertCondition(strpos($privacyHtml, 'Parental Rights &amp; Opt-Out') !== false || strpos($privacyHtml, 'Parental Rights & Opt-Out') !== false, "Section 06 Parental Rights present");
assertCondition(strpos($privacyHtml, 'Grievance Desk &amp; Academy Contact') !== false || strpos($privacyHtml, 'Grievance Desk & Academy Contact') !== false, "Section 07 Grievance Desk present");
assertCondition(strpos($privacyHtml, 'w-full px-3 sm:px-6 lg:px-8 xl:px-12') !== false, "Privacy Policy uses exact responsive padding matching website theme");
assertCondition(strpos($privacyHtml, 'bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500') !== false, "Top iridescent rainbow line present");

// 2. Verify Terms of Service Page (/terms)
echo "\n--- 2. Testing Terms of Service Page (/terms) ---\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/terms';
$termsResp = $publicCtrl->terms(new Request());
$termsHtml = $termsResp->getContent();

assertCondition($termsResp->getStatus() === 200, "Terms page dispatches with HTTP 200");
assertCondition(strpos($termsHtml, 'ACADEMY POLICIES &amp; ENROLMENT GUIDELINES') !== false || strpos($termsHtml, 'ACADEMY POLICIES & ENROLMENT GUIDELINES') !== false, "Terms page contains 'ACADEMY POLICIES & ENROLMENT GUIDELINES' badge");
assertCondition(strpos($termsHtml, 'Terms of Service &amp; Studio Guidelines') !== false || strpos($termsHtml, 'Terms of Service & Studio Guidelines') !== false, "Terms page contains main H1 heading");
assertCondition(strpos($termsHtml, 'Terms Navigation') !== false, "Terms page includes quick navigation index");
assertCondition(strpos($termsHtml, 'Admission, Age Criteria &amp; Enrolment') !== false || strpos($termsHtml, 'Admission, Age Criteria & Enrolment') !== false, "Section 01 Admission Criteria present");
assertCondition(strpos($termsHtml, 'Studio Discipline, Uniform &amp; Conduct') !== false || strpos($termsHtml, 'Studio Discipline, Uniform & Conduct') !== false, "Section 02 Studio Discipline present");
assertCondition(strpos($termsHtml, 'Mandatory 75% Attendance Requirement') !== false, "Section 03 75% Attendance Requirement present");
assertCondition(strpos($termsHtml, 'Fees, Billing &amp; Cancellation Terms') !== false || strpos($termsHtml, 'Fees, Billing & Cancellation Terms') !== false, "Section 04 Fees & Billing present");
assertCondition(strpos($termsHtml, 'Stage Performances &amp; National/International Tours') !== false || strpos($termsHtml, 'Stage Performances & National/International Tours') !== false, "Section 05 Stage Tours present");
assertCondition(strpos($termsHtml, 'Health, Physical Safety &amp; First Aid') !== false || strpos($termsHtml, 'Health, Physical Safety & First Aid') !== false, "Section 06 Health & Safety present");
assertCondition(strpos($termsHtml, 'Choreography &amp; Intellectual Property') !== false || strpos($termsHtml, 'Choreography & Intellectual Property') !== false, "Section 07 Intellectual Property present");
assertCondition(strpos($termsHtml, 'Governing Law &amp; Jurisdiction') !== false || strpos($termsHtml, 'Governing Law & Jurisdiction') !== false, "Section 08 Jurisdiction present");
assertCondition(strpos($termsHtml, 'w-full px-3 sm:px-6 lg:px-8 xl:px-12') !== false, "Terms page uses exact responsive padding matching website theme");
assertCondition(strpos($termsHtml, 'bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500') !== false, "Top iridescent rainbow line present");

// 3. Verify Refund Policy Page (/refund-policy)
echo "\n--- 3. Testing Refund Policy Page (/refund-policy) ---\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/refund-policy';
$refundResp = $publicCtrl->refundPolicy(new Request());
assertCondition($refundResp->getStatus() === 200, "Refund Policy page dispatches with HTTP 200");

echo "\n============================================\n";
echo "Total Passes: {$passes}\n";
echo "Total Errors: " . count($errors) . "\n";
if (empty($errors)) {
    echo "ALL LEGAL PAGES SPEC TESTS PASSED! 100% SUCCESS\n";
    exit(0);
} else {
    echo "FAILURES ENCOUNTERED:\n";
    foreach ($errors as $e) {
        echo " - {$e}\n";
    }
    exit(1);
}
