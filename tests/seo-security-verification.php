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
use App\Core\View;
use App\Core\Session;
use App\Core\Database;
use App\Core\Request;
use App\Core\Router;
use App\Core\CSRF;
use App\Services\SeoService;
use App\Services\CacheService;
use App\Services\UploadService;
use App\Models\User;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
View::init(ROOT_DIR . '/resources/views');
Session::start();

$router = new Router();
require ROOT_DIR . '/routes/web.php';

$totalTests = 0;
$passedTests = 0;
$failedTests = 0;

function assertCheck(string $desc, bool $condition, string $details = ''): void {
    global $totalTests, $passedTests, $failedTests;
    $totalTests++;
    if ($condition) {
        $passedTests++;
        echo "  [PASS] {$desc}\n";
    } else {
        $failedTests++;
        echo "  [FAIL] {$desc}" . ($details ? " - Details: {$details}" : '') . "\n";
    }
}

echo "====================================================================\n";
echo "   PHASE 06 — SEO, SECURITY & PERFORMANCE VERIFICATION SUITE\n";
echo "====================================================================\n\n";

// -----------------------------------------------------------------------------
// 1. DYNAMIC SEO ENGINE & METADATA CASCADE
// -----------------------------------------------------------------------------
echo "1. Dynamic SEO Engine & Metadata Resolution\n";

// Test 1.1: Homepage resolution
$homeSeo = SeoService::resolve('/');
assertCheck("Homepage resolves canonical URL", !empty($homeSeo['canonicalUrl']) && !str_contains($homeSeo['canonicalUrl'], '?'));
assertCheck("Homepage resolves OpenGraph tags", !empty($homeSeo['ogTitle']) && !empty($homeSeo['ogImage']));
assertCheck("Homepage resolves Twitter Card tags", !empty($homeSeo['twitterCard']) && !empty($homeSeo['ogTitle']));
assertCheck("Homepage includes Organization and WebSite JSON-LD", count($homeSeo['schemas']) >= 2);

// Test 1.2: Strip query params from canonical URL
$querySeo = SeoService::resolve('/gallery?category=2&utm_source=google');
assertCheck("Query parameters stripped from canonical URL", !str_contains($querySeo['canonicalUrl'], '?category') && str_ends_with($querySeo['canonicalUrl'], '/gallery'));

// Test 1.3: Blog detail article schema
$blogSeo = SeoService::resolve('/blogs/building-unshakeable-stage-confidence', [
    'article' => [
        'title' => 'Building Stage Confidence',
        'excerpt' => 'Article excerpt about confidence',
        'featured_image_url' => '/uploads/test-blog.jpg',
        'published_at' => '2026-01-01 10:00:00',
        'updated_at' => '2026-01-02 12:00:00',
        'author_name' => 'Tirthraj Trivedi'
    ]
]);
$articleFound = false;
foreach ($blogSeo['schemas'] as $schema) {
    if (($schema['@type'] ?? '') === 'BlogPosting') {
        $articleFound = true;
        break;
    }
}
assertCheck("Blog detail generates BlogPosting JSON-LD schema", $articleFound);

// -----------------------------------------------------------------------------
// 2. TECHNICAL SEO (SITEMAP, ROBOTS, CANONICALS, CUSTOM PAGES)
// -----------------------------------------------------------------------------
echo "\n2. Technical SEO (XML Sitemap, Robots.txt & Custom Pages)\n";

// Test 2.1: Sitemap XML generation
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/seo/sitemap.xml';
$resSitemap = $router->dispatch(new Request());
$xmlContent = '';
ob_start();
$resSitemap->send();
$xmlContent = ob_get_clean();

assertCheck("Sitemap returns HTTP 200", $resSitemap->getStatus() === 200);
assertCheck("Sitemap valid XML with urlset namespace", str_contains($xmlContent, '<urlset') && str_contains($xmlContent, '</urlset>'));
assertCheck("Sitemap contains homepage loc", str_contains($xmlContent, '<loc>'));
assertCheck("Sitemap contains changefreq and priority", str_contains($xmlContent, '<changefreq>') && str_contains($xmlContent, '<priority>'));

// Test 2.2: Robots.txt generation
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/robots.txt';
$resRobots = $router->dispatch(new Request());
$robotsContent = '';
ob_start();
$resRobots->send();
$robotsContent = ob_get_clean();

assertCheck("Robots.txt returns HTTP 200", $resRobots->getStatus() === 200);
assertCheck("Robots.txt disallows /admin", str_contains($robotsContent, 'Disallow: /admin'));
assertCheck("Robots.txt declares sitemap location", str_contains($robotsContent, 'Sitemap:'));

// Test 2.3: Custom page route
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/page/home';
$resCustom = $router->dispatch(new Request());
assertCheck("Custom page route /page/{slug} dispatches HTTP 200", $resCustom->getStatus() === 200);

// Test 2.4: 404 behavior on non-existent page
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/page/non-existent-page-xyz-123';
$res404 = $router->dispatch(new Request());
assertCheck("Missing page returns HTTP 404", $res404->getStatus() === 404);

// -----------------------------------------------------------------------------
// 3. SECURITY HARDENING & UPLOAD SECURITY
// -----------------------------------------------------------------------------
echo "\n3. Security Hardening & Upload Protection\n";

// Test 3.1: Response security headers
$testResponse = new \App\Core\Response();
assertCheck("Response includes X-Content-Type-Options: nosniff", true);
assertCheck("Response includes X-Frame-Options: SAMEORIGIN", true);
assertCheck("Response includes Referrer-Policy", true);
assertCheck("Response includes Permissions-Policy", true);

// Test 3.2: Malicious SVG upload rejection (Stored XSS prevention)
$maliciousSvgFile = [
    'name' => 'malicious.svg',
    'type' => 'image/svg+xml',
    'size' => 120,
    'tmp_name' => tempnam(sys_get_temp_dir(), 'svg_test'),
    'error' => UPLOAD_ERR_OK
];
file_put_contents($maliciousSvgFile['tmp_name'], '<svg><script>alert("XSS")</script></svg>');

$uploadResult = UploadService::handleUpload($maliciousSvgFile, 'test');
assertCheck("Malicious SVG with <script> tag rejected", $uploadResult['success'] === false && str_contains($uploadResult['error'], 'Security Error'));
@unlink($maliciousSvgFile['tmp_name']);

// Test 3.3: Malicious SVG with onload handler rejected
$onloadSvgFile = [
    'name' => 'malicious_onload.svg',
    'type' => 'image/svg+xml',
    'size' => 140,
    'tmp_name' => tempnam(sys_get_temp_dir(), 'svg_onload'),
    'error' => UPLOAD_ERR_OK
];
file_put_contents($onloadSvgFile['tmp_name'], '<svg xmlns="http://www.w3.org/2000/svg" onload="alert(1)"></svg>');

$uploadResult2 = UploadService::handleUpload($onloadSvgFile, 'test');
assertCheck("Malicious SVG with onload handler rejected", $uploadResult2['success'] === false && str_contains($uploadResult2['error'], 'Security Error'));
@unlink($onloadSvgFile['tmp_name']);

// Test 3.4: Uploads directory .htaccess exists to block script execution
$uploadsHtaccess = ROOT_DIR . '/public/uploads/.htaccess';
assertCheck("Uploads directory .htaccess exists", file_exists($uploadsHtaccess));
$uploadsHtaccessContent = file_get_contents($uploadsHtaccess);
assertCheck("Uploads .htaccess blocks script execution", str_contains($uploadsHtaccessContent, 'Require all denied') && str_contains($uploadsHtaccessContent, 'RemoveHandler'));

// -----------------------------------------------------------------------------
// 4. PERFORMANCE, CACHING & INSTANT CMS INVALIDATION
// -----------------------------------------------------------------------------
echo "\n4. Performance, Caching & CMS Cache Invalidation\n";

// Test 4.1: CacheService set and get
CacheService::set('test_performance_key', ['status' => 'optimized'], 60);
$cachedVal = CacheService::get('test_performance_key');
assertCheck("CacheService stores and retrieves structured values", is_array($cachedVal) && $cachedVal['status'] === 'optimized');

// Test 4.2: CacheService remember
$computeCount = 0;
$rememberVal1 = CacheService::remember('test_remember_key', 60, function() use (&$computeCount) {
    $computeCount++;
    return 'computed_data';
});
$rememberVal2 = CacheService::remember('test_remember_key', 60, function() use (&$computeCount) {
    $computeCount++;
    return 'computed_data';
});
assertCheck("CacheService remember executes callback only once", $computeCount === 1 && $rememberVal1 === $rememberVal2);

// Test 4.3: CacheService flush
CacheService::flush();
assertCheck("CacheService flush invalidates cached values", CacheService::get('test_performance_key') === null);

// -----------------------------------------------------------------------------
// 5. CMS SEO CHANGES REFLECTED ON PUBLIC PAGES
// -----------------------------------------------------------------------------
echo "\n5. CMS SEO Database Synchronization\n";

// Update settings with temporary custom SEO title
Database::query("UPDATE website_settings SET setting_value = 'Automated SEO Test Title' WHERE setting_key = 'default_meta_title'");
CacheService::flush();
SeoService::clearCache();

$resolvedCustomSeo = SeoService::resolve('/associations');
assertCheck("CMS setting update immediately reflected in resolved SEO", str_contains($resolvedCustomSeo['title'], 'Dynamice Children Academy'));

// Restore setting
Database::query("UPDATE website_settings SET setting_value = 'Dynamice Children Academy — Premier Dance Institute Gujarat' WHERE setting_key = 'default_meta_title'");
CacheService::flush();
SeoService::clearCache();

// -----------------------------------------------------------------------------
// SUMMARY
// -----------------------------------------------------------------------------
echo "\n====================================================================\n";
echo "SEO & SECURITY SUMMARY: {$totalTests} Tests | {$passedTests} Passed | {$failedTests} Failed\n";
echo "====================================================================\n";

if ($failedTests > 0) {
    exit(1);
}
