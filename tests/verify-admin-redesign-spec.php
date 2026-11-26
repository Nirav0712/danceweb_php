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
use App\Core\Session;
use App\Controllers\DashboardController;
use App\Controllers\Admin\HeroController;
use App\Controllers\Admin\DanceCategoriesController;
use App\Controllers\Admin\TourFlagsController;
use App\Controllers\Admin\AwardsController;
use App\Controllers\Admin\TestimonialsController;
use App\Controllers\Admin\AboutController;
use App\Controllers\Admin\JourneyEventsController;
use App\Controllers\Admin\BlogsController;
use App\Controllers\Admin\NewsItemsController;
use App\Controllers\Admin\GalleryController;
use App\Controllers\Admin\BranchesController;
use App\Controllers\Admin\EnquiriesController;
use App\Controllers\Admin\SettingsController;

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

echo "Starting Admin Panel Redesign Verification Spec...\n\n";

// 1. Verify Admin Dashboard
echo "--- 1. Testing Admin Dashboard (/admin) ---\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/admin';
$dashCtrl = new DashboardController();
$req = new Request();
$dashResp = $dashCtrl->index($req);
$dashHtml = $dashResp->getContent();

assertCondition(strpos($dashHtml, 'Website Content Management') !== false, "Dashboard title is clear and non-technical");
assertCondition(strpos($dashHtml, 'Homepage Sections Flow (Top to Bottom)') !== false, "Dashboard features Homepage Sections Flow card");
assertCondition(strpos($dashHtml, 'Main Website Pages (Navbar Sequence)') !== false, "Dashboard features Main Website Pages Navigator card");
assertCondition(strpos($dashHtml, 'Hero Banner &amp; Heading') !== false || strpos($dashHtml, 'Hero Banner & Heading') !== false, "Section 01 Hero Banner present on dashboard");
assertCondition(strpos($dashHtml, 'Services &amp; Dance Disciplines') !== false || strpos($dashHtml, 'Services & Dance Disciplines') !== false, "Section 02 Dance Disciplines present on dashboard");
assertCondition(strpos($dashHtml, 'Tour Flags Carousel') !== false, "Section 03 Tour Flags present on dashboard");
assertCondition(strpos($dashHtml, 'Awards &amp; Records Showcase') !== false || strpos($dashHtml, 'Awards & Records Showcase') !== false, "Section 04 Awards present on dashboard");
assertCondition(strpos($dashHtml, 'Words From Our Families') !== false, "Section 05 Families present on dashboard");
assertCondition(strpos($dashHtml, 'Recent Admission Inquiries') !== false, "Recent admission leads card present");

// 2. Verify Layout & Sidebar Navigation
echo "\n--- 2. Testing Layout & Sidebar Navigation Hierarchy ---\n";
assertCondition(strpos($dashHtml, 'Homepage Sections (Top to Bottom)') !== false, "Sidebar contains 'Homepage Sections (Top to Bottom)' group");
assertCondition(strpos($dashHtml, 'Navbar Pages (Full Pages)') !== false, "Sidebar contains 'Navbar Pages (Full Pages)' group");
assertCondition(strpos($dashHtml, 'Inquiries &amp; Settings') !== false || strpos($dashHtml, 'Inquiries & Settings') !== false, "Sidebar contains 'Inquiries & Settings' group");
assertCondition(strpos($dashHtml, 'View Public Website') !== false, "Sidebar features quick 'View Public Website' action");
assertCondition(strpos($dashHtml, 'Universal Drag &amp; Drop Image Uploader') !== false || strpos($dashHtml, 'live-image-preview') !== false, "Universal drag and drop image uploader script integrated");

// 3. Verify Admin Route Controllers Load with Clean UI
echo "\n--- 3. Testing Admin Module Controllers Load Successfully ---\n";
$modules = [
    'Hero' => fn() => (new HeroController())->index(new Request()),
    'Curriculum' => fn() => (new DanceCategoriesController())->index(new Request()),
    'Tour Flags' => fn() => (new TourFlagsController())->index(new Request()),
    'Awards' => fn() => (new AwardsController())->index(new Request()),
    'Testimonials' => fn() => (new TestimonialsController())->index(new Request()),
    'About' => fn() => (new AboutController())->index(new Request()),
    'National Journey' => fn() => (new JourneyEventsController('NATIONAL'))->index(new Request()),
    'International Journey' => fn() => (new JourneyEventsController('INTERNATIONAL'))->index(new Request()),
    'Blogs' => fn() => (new BlogsController())->index(new Request()),
    'National News' => fn() => (new NewsItemsController('NATIONAL'))->index(new Request()),
    'International News' => fn() => (new NewsItemsController('INTERNATIONAL'))->index(new Request()),
    'Gallery' => fn() => (new GalleryController())->index(new Request()),
    'Branches & Contact' => fn() => (new BranchesController())->index(new Request()),
    'Enquiries' => fn() => (new EnquiriesController())->index(new Request()),
    'Settings' => fn() => (new SettingsController())->index(new Request()),
];

foreach ($modules as $name => $fn) {
    try {
        $res = $fn();
        $status = $res->getStatus();
        assertCondition($status === 200, "Module '{$name}' renders with HTTP 200");
    } catch (\Throwable $e) {
        assertCondition(false, "Module '{$name}' crashed: " . $e->getMessage());
    }
}

echo "\n============================================\n";
echo "Total Passes: {$passes}\n";
echo "Total Errors: " . count($errors) . "\n";
if (empty($errors)) {
    echo "ALL ADMIN REDESIGN SPEC TESTS PASSED! 100% SUCCESS\n";
    exit(0);
} else {
    echo "FAILURES ENCOUNTERED:\n";
    foreach ($errors as $e) {
        echo " - {$e}\n";
    }
    exit(1);
}
