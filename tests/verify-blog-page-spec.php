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
use App\Controllers\Admin\BlogsController;

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

// Ensure default authentic settings in DB
Database::query("UPDATE pages SET title = 'Dance Stories & Insights', subtitle = 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.' WHERE slug = 'blog'");

$blogHeaderSec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'blog_header'");
if (!$blogHeaderSec) {
    $page = Database::fetchOne("SELECT id FROM pages WHERE slug = 'blog'");
    Database::query(
        "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
         VALUES (:pid, 'blog_header', 'Dance Stories & Insights', 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.', 'PERSPECTIVES & WISDOM', 1, NOW(), NOW())",
        ['pid' => $page['id'] ?? 1]
    );
} else {
    Database::query("UPDATE sections SET heading = 'Dance Stories & Insights', subheading = 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.', content = 'PERSPECTIVES & WISDOM' WHERE section_key = 'blog_header'");
}

echo "=== 1. VERIFYING PUBLIC /blog AND /blogs RENDERING (SCREENSHOT MATCHING) ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/blog';
$_POST = [];

$publicController = new PublicController();
$res = $publicController->blogs(new Request());
$html = $res->getBody();

$checks = [
    'Hero Heading (Dance Stories & Insights)' => strpos($html, 'Dance Stories & Insights') !== false,
    'Hero Pill Badge (PERSPECTIVES & WISDOM)' => strpos($html, 'PERSPECTIVES &amp; WISDOM') !== false || strpos($html, 'PERSPECTIVES') !== false,
    'Hero Subtitle' => strpos($html, 'Reflections on pedagogy, Indian performing arts traditions') !== false,
    'Iridescent Top Rainbow Line' => strpos($html, 'bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500') !== false,
    'Disciplines matching padding (w-full px-3 sm:px-6 lg:px-8 xl:px-12)' => strpos($html, 'w-full px-3 sm:px-6 lg:px-8 xl:px-12') !== false,
    '3-Column Card Grid' => strpos($html, 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3') !== false,
    'Culture Category Badge' => strpos($html, 'Culture') !== false,
    'Read Full Article Link' => strpos($html, 'Read Full Article') !== false,
];

foreach ($checks as $name => $ok) {
    if ($ok) {
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name}\n";
        $allPassed = false;
    }
}

echo "\n=== 2. VERIFYING PUBLIC /blog/{slug} AND /blogs/{slug} DETAIL VIEW ===\n";
$latestPost = Database::fetchOne("SELECT * FROM blog_posts WHERE status = 'PUBLISHED' ORDER BY published_at DESC LIMIT 1");
if ($latestPost) {
    $resDetail = $publicController->blogDetail(new Request(), ['slug' => $latestPost['slug']]);
    $htmlDetail = $resDetail->getBody();
    
    $detailChecks = [
        'Detail Title rendered' => strpos($htmlDetail, htmlspecialchars($latestPost['title'])) !== false,
        'Detail Rainbow Line' => strpos($htmlDetail, 'bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400') !== false,
        'Detail Back Link' => strpos($htmlDetail, 'All Articles') !== false || strpos($htmlDetail, 'Return to All Dance Stories') !== false,
        'Detail Author rendered' => strpos($htmlDetail, htmlspecialchars($latestPost['author_name'])) !== false,
        'Detail Responsive Padding' => strpos($htmlDetail, 'px-3 sm:px-6 lg:px-8 xl:px-12') !== false,
    ];

    foreach ($detailChecks as $name => $ok) {
        if ($ok) {
            echo "  [PASS] {$name}\n";
        } else {
            echo "  [FAIL] {$name}\n";
            $allPassed = false;
        }
    }
} else {
    echo "  [SKIP] No published blog post found to test detail view.\n";
}

echo "\n=== 3. VERIFYING ADMIN /admin/blogs DASHBOARD & SETTINGS CMS ===\n";
$blogsController = new BlogsController();
$adminRes = $blogsController->index(new Request());
$adminHtml = $adminRes->getBody();

$adminChecks = [
    'Admin Header CMS Form Present' => strpos($adminHtml, 'Page Header & Banner CMS Settings') !== false,
    'Admin Badge Input Present' => strpos($adminHtml, 'name="badge_label"') !== false,
    'Admin Page Title Input Present' => strpos($adminHtml, 'name="page_title"') !== false,
    'Admin Subtitle Input Present' => strpos($adminHtml, 'name="page_subtitle"') !== false,
    'Admin Write Story Modal' => strpos($adminHtml, 'id="createBlogModal"') !== false,
    'Admin Edit Story Modal' => strpos($adminHtml, 'id="editBlogModal"') !== false,
    'Admin Image Upload field' => strpos($adminHtml, 'name="image_file"') !== false,
];

foreach ($adminChecks as $name => $ok) {
    if ($ok) {
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name}\n";
        $allPassed = false;
    }
}

echo "\n=== 4. TESTING ADMIN CMS UPDATE & CRUD OPERATIONS ===\n";
// 4a. Update settings
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'csrf_token' => $csrfToken,
    'badge_label' => 'PERSPECTIVES & WISDOM VERIFIED',
    'page_title' => 'Dance Stories & Insights CMS',
    'page_subtitle' => 'Live customized subtitle tested via automated CMS suite.',
    'meta_title' => 'SEO Title Verified',
    'meta_description' => 'SEO Desc Verified',
];
$settingsRes = $blogsController->updateSettings(new Request());
$savedSec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'blog_header'");
$savedPage = Database::fetchOne("SELECT * FROM pages WHERE slug = 'blog'");

if ($savedSec['content'] === 'PERSPECTIVES & WISDOM VERIFIED' && $savedPage['title'] === 'Dance Stories & Insights CMS') {
    echo "  [PASS] Admin Settings Update (Badge & Heading updated in DB)\n";
} else {
    echo "  [FAIL] Admin Settings Update (Expected 'PERSPECTIVES & WISDOM VERIFIED', got '{$savedSec['content']}')\n";
    $allPassed = false;
}

// Revert settings to clean state
$_POST = [
    'csrf_token' => $csrfToken,
    'badge_label' => 'PERSPECTIVES & WISDOM',
    'page_title' => 'Dance Stories & Insights',
    'page_subtitle' => 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.',
    'meta_title' => 'Dynamice Children Academy | Dance Stories & Insights',
    'meta_description' => 'Reflections on pedagogy, Indian performing arts traditions, and artistic growth for young learners.',
];
$blogsController->updateSettings(new Request());

// 4b. Test Create, Update, and Delete Story
$testSlug = 'unit-test-story-' . time();
$_POST = [
    'csrf_token' => $csrfToken,
    'title' => 'Automated Test Story',
    'slug' => $testSlug,
    'category' => 'Culture',
    'author_name' => 'Automated Tester',
    'featured_image_url' => '/assets/gallery/5.jpg',
    'status' => 'PUBLISHED',
    'excerpt' => 'Test excerpt for automated test.',
    'content' => 'Full article content created by automated verification suite.',
];
$createRes = $blogsController->store(new Request());
$created = Database::fetchOne("SELECT * FROM blog_posts WHERE slug = :slug", ['slug' => $testSlug]);

if ($created && $created['title'] === 'Automated Test Story') {
    echo "  [PASS] Admin Store Story (Created blog post with ID {$created['id']})\n";

    // Update story
    $_POST = [
        'csrf_token' => $csrfToken,
        'title' => 'Automated Test Story Updated',
        'slug' => $testSlug,
        'category' => 'Dance Education',
        'author_name' => 'Automated Tester 2',
        'featured_image_url' => '/assets/gallery/6.jpg',
        'status' => 'PUBLISHED',
        'excerpt' => 'Updated excerpt.',
        'content' => 'Updated content.',
    ];
    $updateRes = $blogsController->update(new Request(), ['id' => $created['id']]);
    $updated = Database::fetchOne("SELECT * FROM blog_posts WHERE id = :id", ['id' => $created['id']]);

    if ($updated && $updated['title'] === 'Automated Test Story Updated' && $updated['category'] === 'Dance Education') {
        echo "  [PASS] Admin Update Story (Updated title and category successfully)\n";
    } else {
        echo "  [FAIL] Admin Update Story\n";
        $allPassed = false;
    }

    // Delete story
    $_POST = ['csrf_token' => $csrfToken];
    $deleteRes = $blogsController->delete(new Request(), ['id' => $created['id']]);
    $deleted = Database::fetchOne("SELECT * FROM blog_posts WHERE id = :id", ['id' => $created['id']]);
    if (!$deleted) {
        echo "  [PASS] Admin Delete Story (Cleaned up test post)\n";
    } else {
        echo "  [FAIL] Admin Delete Story\n";
        $allPassed = false;
    }
} else {
    echo "  [FAIL] Admin Store Story\n";
    $allPassed = false;
}

if ($allPassed) {
    echo "\n>>> ALL BLOG SPEC TESTS PASSED! 100% SUCCESS <<<\n";
    exit(0);
} else {
    echo "\n>>> SOME BLOG SPEC TESTS FAILED! <<<\n";
    exit(1);
}
