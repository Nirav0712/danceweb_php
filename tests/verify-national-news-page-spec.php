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
use App\Controllers\Admin\NewsItemsController;

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

// Set authentic defaults in DB
Database::query("UPDATE pages SET title = 'National News & Media', subtitle = 'Press clippings and national print media coverage celebrating our performances and world record events.' WHERE slug = 'news-national'");

$newsHeaderSec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'news_national_header'");
if (!$newsHeaderSec) {
    $page = Database::fetchOne("SELECT id FROM pages WHERE slug = 'news-national'");
    Database::query(
        "INSERT INTO sections (page_id, section_key, heading, subheading, content, is_visible, created_at, updated_at)
         VALUES (:pid, 'news_national_header', 'National News & Media', 'Press clippings and national print media coverage celebrating our performances and world record events.', 'IN THE HEADLINES', 1, NOW(), NOW())",
        ['pid' => $page['id'] ?? 1]
    );
} else {
    Database::query("UPDATE sections SET heading = 'National News & Media', subheading = 'Press clippings and national print media coverage celebrating our performances and world record events.', content = 'IN THE HEADLINES' WHERE section_key = 'news_national_header'");
}

echo "=== 1. VERIFYING PUBLIC /news/national RENDERING (SCREENSHOT MATCHING) ===\n";
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/news/national';
$_POST = [];

$publicController = new PublicController();
$res = $publicController->nationalNews(new Request());
$html = $res->getBody();

$checks = [
    'Hero Heading (National News & Media)' => strpos($html, 'National News & Media') !== false,
    'Hero Pill Badge (IN THE HEADLINES)' => strpos($html, 'IN THE HEADLINES') !== false,
    'Hero Subtitle' => strpos($html, 'Press clippings and national print media coverage') !== false,
    'Iridescent Top Rainbow Line' => strpos($html, 'bg-gradient-to-r from-pink-500 via-amber-400 via-emerald-400 via-cyan-400 to-purple-500') !== false,
    'Disciplines matching padding (w-full px-3 sm:px-6 lg:px-8 xl:px-12)' => strpos($html, 'w-full px-3 sm:px-6 lg:px-8 xl:px-12') !== false,
    '3-Column Card Grid' => strpos($html, 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3') !== false,
    'Publication Badge (Punjab Kesari)' => strpos($html, 'Punjab Kesari') !== false,
    'Headline (Test Press Release)' => strpos($html, 'Test Press Release') !== false,
    'Lightbox Zoom Trigger (View Newspaper Clipping)' => strpos($html, 'View Newspaper Clipping') !== false,
    'Lightbox Modal Markup present' => strpos($html, 'id="imageLightboxModal"') !== false,
    'Lightbox JavaScript function present' => strpos($html, 'function openLightbox') !== false,
];

foreach ($checks as $name => $ok) {
    if ($ok) {
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name}\n";
        $allPassed = false;
    }
}

echo "\n=== 2. VERIFYING ADMIN /admin/news/national MANAGEMENT & CMS ===\n";
$newsController = new NewsItemsController('NATIONAL');
$adminRes = $newsController->index(new Request());
$adminHtml = $adminRes->getBody();

$adminChecks = [
    'Admin Header CMS Form Present' => strpos($adminHtml, 'Page Header & Banner CMS Settings') !== false,
    'Admin Badge Input Present' => strpos($adminHtml, 'name="badge_label"') !== false,
    'Admin Page Title Input Present' => strpos($adminHtml, 'name="page_title"') !== false,
    'Admin Subtitle Input Present' => strpos($adminHtml, 'name="page_subtitle"') !== false,
    'Admin Add News Modal' => strpos($adminHtml, 'id="createNewsModal"') !== false,
    'Admin Edit News Modal' => strpos($adminHtml, 'id="editNewsModal"') !== false,
    'Admin File Upload field present' => strpos($adminHtml, 'name="image_file"') !== false,
    'Admin Table List present' => strpos($adminHtml, 'News Clippings & Articles') !== false,
];

foreach ($adminChecks as $name => $ok) {
    if ($ok) {
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name}\n";
        $allPassed = false;
    }
}

echo "\n=== 3. TESTING ADMIN CMS SETTINGS UPDATE & CRUD OPERATIONS ===\n";
// 3a. Update settings
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = [
    'csrf_token' => $csrfToken,
    'badge_label' => 'IN THE HEADLINES VERIFIED',
    'page_title' => 'National News & Media CMS',
    'page_subtitle' => 'Automated test verification subtitle.',
    'meta_title' => 'SEO Title Verified',
    'meta_description' => 'SEO Desc Verified',
];
$settingsRes = $newsController->updateSettings(new Request());
$savedSec = Database::fetchOne("SELECT * FROM sections WHERE section_key = 'news_national_header'");
$savedPage = Database::fetchOne("SELECT * FROM pages WHERE slug = 'news-national'");

if ($savedSec['content'] === 'IN THE HEADLINES VERIFIED' && $savedPage['title'] === 'National News & Media CMS') {
    echo "  [PASS] Admin Settings Update (Badge & Heading updated in DB)\n";
} else {
    echo "  [FAIL] Admin Settings Update\n";
    $allPassed = false;
}

// Revert settings to clean authentic state
$_POST = [
    'csrf_token' => $csrfToken,
    'badge_label' => 'IN THE HEADLINES',
    'page_title' => 'National News & Media',
    'page_subtitle' => 'Press clippings and national print media coverage celebrating our performances and world record events.',
    'meta_title' => 'National News & Press Coverage | Dynamice Children Academy',
    'meta_description' => 'Press clippings and national print media coverage celebrating our performances and world record events.',
];
$newsController->updateSettings(new Request());

// 3b. Store, Update, and Delete News Item
$_POST = [
    'csrf_token' => $csrfToken,
    'headline' => 'Automated Test News Clipping',
    'publication_name' => 'Punjab Kesari',
    'publish_date' => date('Y-m-d'),
    'image_url' => '/assets/gallery/5.jpg',
    'summary' => 'Test summary description for national news.',
    'external_link' => 'https://punjabkesari.in/test',
    'sort_order' => '1',
];
$storeRes = $newsController->store(new Request());
$created = Database::fetchOne("SELECT * FROM news_items WHERE headline = 'Automated Test News Clipping' AND news_scope = 'NATIONAL'");

if ($created && $created['publication_name'] === 'Punjab Kesari') {
    echo "  [PASS] Admin Store News Clipping (Created ID {$created['id']})\n";

    // Update
    $_POST = [
        'csrf_token' => $csrfToken,
        'headline' => 'Automated Test News Clipping Updated',
        'publication_name' => 'Divya Bhaskar',
        'publish_date' => date('Y-m-d'),
        'image_url' => '/assets/gallery/6.jpg',
        'summary' => 'Updated summary.',
        'external_link' => '',
        'sort_order' => '2',
    ];
    $updateRes = $newsController->update(new Request(), ['id' => $created['id']]);
    $updated = Database::fetchOne("SELECT * FROM news_items WHERE id = :id", ['id' => $created['id']]);

    if ($updated && $updated['headline'] === 'Automated Test News Clipping Updated' && $updated['publication_name'] === 'Divya Bhaskar') {
        echo "  [PASS] Admin Update News Clipping (Updated successfully)\n";
    } else {
        echo "  [FAIL] Admin Update News Clipping\n";
        $allPassed = false;
    }

    // Delete
    $_POST = ['csrf_token' => $csrfToken];
    $deleteRes = $newsController->delete(new Request(), ['id' => $created['id']]);
    $deleted = Database::fetchOne("SELECT * FROM news_items WHERE id = :id", ['id' => $created['id']]);
    if (!$deleted) {
        echo "  [PASS] Admin Delete News Clipping (Cleaned up test item)\n";
    } else {
        echo "  [FAIL] Admin Delete News Clipping\n";
        $allPassed = false;
    }
} else {
    echo "  [FAIL] Admin Store News Clipping\n";
    $allPassed = false;
}

if ($allPassed) {
    echo "\n>>> ALL NATIONAL NEWS SPEC TESTS PASSED! 100% SUCCESS <<<\n";
    exit(0);
} else {
    echo "\n>>> SOME NATIONAL NEWS SPEC TESTS FAILED! <<<\n";
    exit(1);
}
