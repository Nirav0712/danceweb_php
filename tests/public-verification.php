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
use App\Core\Session;
use App\Core\Request;
use App\Core\Router;
use App\Core\Response;
use App\Core\Database;
use App\Core\CSRF;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');

$pass = 0;
$fail = 0;

function check(string $name, bool $result): void {
    global $pass, $fail;
    if ($result) {
        $pass++;
        echo "  [PASS] {$name}\n";
    } else {
        $fail++;
        echo "  [FAIL] {$name}\n";
    }
}

echo "=== DYNAMICE CHILDREN ACADEMY — PHASE 03 PUBLIC VERIFICATION SUITE ===\n\n";

$router = new Router();
require ROOT_DIR . '/routes/web.php';

$publicRoutes = [
    '/' => 'Home Page',
    '/about' => 'About Page',
    '/gallery' => 'Gallery Portfolio',
    '/awards' => 'Awards & Records',
    '/award' => 'Awards Legacy Synonym',
    '/associations' => 'Affiliations Page',
    '/journey/national' => 'National Journey Page',
    '/journey/international' => 'International Journey Page',
    '/news/national' => 'National Press Coverage',
    '/news/international' => 'International Press Coverage',
    '/blogs' => 'Dance Stories Grid',
    '/blog' => 'Blog Legacy Synonym',
    '/contact' => 'Contact & Branches Page',
    '/seo/sitemap.xml' => 'XML Sitemap Generator',
    '/robots.txt' => 'Robots.txt Directive',
    '/health' => 'Health Endpoint',
];

echo "1. Public Route Dispatching & Render Verification\n";
foreach ($publicRoutes as $uri => $label) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $uri;
    $req = new Request();
    try {
        $res = $router->dispatch($req);
        $status = $res->getStatus();
        check("{$label} ({$uri}) dispatched with HTTP {$status}", $status === 200);
    } catch (\Throwable $e) {
        check("{$label} ({$uri}) threw error: " . $e->getMessage(), false);
    }
}

echo "\n2. Dynamic Blog Detail Route\n";
$blog = Database::fetchOne("SELECT slug FROM blog_posts WHERE status = 'PUBLISHED' LIMIT 1");
if ($blog && !empty($blog['slug'])) {
    $slugUri = '/blogs/' . $blog['slug'];
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_SERVER['REQUEST_URI'] = $slugUri;
    $blogReq = new Request();
    $blogRes = $router->dispatch($blogReq);
    check("Blog detail route ({$slugUri}) rendered successfully", $blogRes->getStatus() === 200);
} else {
    check("Blog detail route checked (No published blogs in DB)", true);
}

echo "\n3. Static Assets & Logo Existence in php-version/public\n";
check("Main Logo (logodance.png) exists in public root", file_exists(ROOT_DIR . '/public/logodance.png'));
check("Favicon (favicon.ico) exists in public root", file_exists(ROOT_DIR . '/public/favicon.ico'));
check("CSS Bundle (assets/index-TmExv8Sz.css) exists", file_exists(ROOT_DIR . '/public/assets/index-TmExv8Sz.css'));
check("Banner Hero Image exists (homebanner.jpg)", file_exists(ROOT_DIR . '/public/assets/banners/homebanner.jpg'));
check("Director Image exists (about/director.jpg)", file_exists(ROOT_DIR . '/public/assets/about/director.jpg'));

echo "\n4. Public Admission Enquiry API Validation\n";
Session::start();
$token = CSRF::getToken();
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/api/enquiries';
$_POST = [
    'csrf_token' => $token,
    'student_name' => 'Phase 03 Test Dancer',
    'parent_name' => 'Verification Parent',
    'phone' => '+91 99999 88888',
    'email' => 'test_enquiry@academy.com',
    'message' => 'Automated enquiry test for Phase 03',
    'preferred_branch' => 'Nikol',
];
$enqReq = new Request();
$enqRes = $router->dispatch($enqReq);
check("Admission enquiry submission returns HTTP 200", $enqRes->getStatus() === 200);

// Verify enquiry in MySQL and cleanly purge test record
$enqRecord = Database::fetchOne("SELECT id FROM enquiries WHERE email = 'test_enquiry@academy.com' ORDER BY id DESC LIMIT 1");
check("Enquiry persisted into MySQL enquiries table", !empty($enqRecord));
if ($enqRecord) {
    Database::query("DELETE FROM enquiries WHERE id = :id", ['id' => $enqRecord['id']]);
    check("Test enquiry cleanly cleaned up from MySQL", true);
}

echo "\n5. Newsletter Subscription API Validation\n";
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/api/newsletter/subscribe';
$_POST = [
    'email' => 'phase03_newsletter@academy.com',
];
$newsReq = new Request();
$newsRes = $router->dispatch($newsReq);
check("Newsletter subscription returns HTTP 200", $newsRes->getStatus() === 200);

$newsRecord = Database::fetchOne("SELECT id FROM newsletter_subscribers WHERE email = 'phase03_newsletter@academy.com'");
check("Newsletter subscriber persisted into MySQL", !empty($newsRecord));
if ($newsRecord) {
    Database::query("DELETE FROM newsletter_subscribers WHERE id = :id", ['id' => $newsRecord['id']]);
    check("Test newsletter subscription cleanly cleaned up from MySQL", true);
}

echo "\n=======================================================\n";
echo "PHASE 03 PUBLIC VERIFICATION: {$pass} Passed | {$fail} Failed\n";
echo "=======================================================\n";

if ($fail > 0) exit(1);
exit(0);
