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
use App\Services\CacheService;
use App\Services\SeoService;
use App\Models\User;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
View::init(ROOT_DIR . '/resources/views');
Session::start();

$router = new Router();
require ROOT_DIR . '/routes/web.php';

$totalQA = 0;
$passedQA = 0;
$failedQA = 0;

function assertQA(string $desc, bool $condition, string $details = ''): void {
    global $totalQA, $passedQA, $failedQA;
    $totalQA++;
    if ($condition) {
        $passedQA++;
        echo "  [PASS] {$desc}\n";
    } else {
        $failedQA++;
        echo "  [FAIL] {$desc}" . ($details ? " - Details: {$details}" : '') . "\n";
    }
}

echo "====================================================================\n";
echo "   PHASE 07 — ADMIN CMS END-TO-END CRUD QA & TEARDOWN SUITE\n";
echo "====================================================================\n\n";

// Authenticate as SUPER_ADMIN
$admin = User::findByEmail('admin@dynamicechildrenacademy.com');
if (!$admin) {
    echo "Fatal: Admin user not found.\n";
    exit(1);
}

Session::set('user_id', (int)$admin['id']);
Session::set('role', $admin['role']);
Session::set('email', $admin['email']);
Session::set('full_name', $admin['full_name']);

$csrf = CSRF::getToken();

function dispatchPost(string $uri, array $postData, Router $router): \App\Core\Response {
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_SERVER['REQUEST_URI'] = $uri;
    $_POST = $postData;
    return $router->dispatch(new Request());
}

// -----------------------------------------------------------------------------
// MODULE 01: PHOTO GALLERY
// -----------------------------------------------------------------------------
echo "1. Testing Module: Photo Gallery\n";
$cat = Database::fetchOne('SELECT id FROM dance_categories LIMIT 1');
$catId = $cat['id'] ?? null;

$res = dispatchPost('/admin/gallery', [
    'csrf_token' => $csrf,
    'title' => 'QA Temp Gallery Item',
    'caption' => 'QA Caption Initial',
    'image_url' => '/uploads/qa_gallery.jpg',
    'category_id' => $catId,
    'sort_order' => 999,
], $router);
assertQA("Gallery: Create record returned redirect (302)", $res->getStatus() === 302);
$createdGallery = Database::fetchOne("SELECT * FROM gallery_items WHERE title = 'QA Temp Gallery Item'");
assertQA("Gallery: Record persisted in MySQL", !empty($createdGallery));
$gId = $createdGallery['id'] ?? 0;

// Update
$res = dispatchPost("/admin/gallery/{$gId}/update", [
    'csrf_token' => $csrf,
    'title' => 'QA Temp Gallery Item Edited',
    'caption' => 'QA Caption Updated',
    'image_url' => '/uploads/qa_gallery_edited.jpg',
    'category_id' => $catId,
    'sort_order' => 998,
], $router);
assertQA("Gallery: Edit update returned redirect (302)", $res->getStatus() === 302);
$updatedGallery = Database::fetchOne("SELECT * FROM gallery_items WHERE id = :id", ['id' => $gId]);
assertQA("Gallery: Updates persisted in MySQL", $updatedGallery['title'] === 'QA Temp Gallery Item Edited' && $updatedGallery['caption'] === 'QA Caption Updated');

// Delete
$res = dispatchPost("/admin/gallery/{$gId}/delete", ['csrf_token' => $csrf], $router);
assertQA("Gallery: Delete returned redirect without 500 error", $res->getStatus() === 302);
$checkGallery = Database::fetchOne("SELECT * FROM gallery_items WHERE id = :id", ['id' => $gId]);
assertQA("Gallery: Record cleanly removed from database", empty($checkGallery));

// -----------------------------------------------------------------------------
// MODULE 02: AWARDS & RECORDS
// -----------------------------------------------------------------------------
echo "\n2. Testing Module: Awards & World Records\n";
$res = dispatchPost('/admin/awards', [
    'csrf_token' => $csrf,
    'title' => 'QA Temp World Record',
    'issuer' => 'Golden Book of Records',
    'category' => 'INTERNATIONAL',
    'year' => 2026,
    'description' => 'QA Description',
    'sort_order' => 999,
], $router);
assertQA("Awards: Create record returned redirect (302)", $res->getStatus() === 302);
$createdAward = Database::fetchOne("SELECT * FROM awards WHERE title = 'QA Temp World Record'");
assertQA("Awards: Record persisted in MySQL", !empty($createdAward));
$aId = $createdAward['id'] ?? 0;

$res = dispatchPost("/admin/awards/{$aId}/update", [
    'csrf_token' => $csrf,
    'title' => 'QA Temp World Record Edited',
    'issuer' => 'Limca Book of Records',
    'category' => 'NATIONAL',
    'year' => 2025,
    'description' => 'QA Description Edited',
    'sort_order' => 998,
], $router);
assertQA("Awards: Edit update returned redirect (302)", $res->getStatus() === 302);
$updatedAward = Database::fetchOne("SELECT * FROM awards WHERE id = :id", ['id' => $aId]);
assertQA("Awards: Updates persisted in MySQL", $updatedAward['title'] === 'QA Temp World Record Edited' && $updatedAward['issuer'] === 'Limca Book of Records');

$res = dispatchPost("/admin/awards/{$aId}/delete", ['csrf_token' => $csrf], $router);
assertQA("Awards: Delete returned redirect without 500 error", $res->getStatus() === 302);
assertQA("Awards: Record cleanly removed from database", empty(Database::fetchOne("SELECT * FROM awards WHERE id = :id", ['id' => $aId])));

// -----------------------------------------------------------------------------
// MODULE 03: DANCE CATEGORIES
// -----------------------------------------------------------------------------
echo "\n3. Testing Module: Dance Categories\n";
$res = dispatchPost('/admin/dance-categories', [
    'csrf_token' => $csrf,
    'name' => 'QA Category Discipline',
    'slug' => 'qa-category-discipline',
    'description' => 'QA Category Description',
    'sort_order' => 999,
    'is_active' => '1',
], $router);
assertQA("DanceCategory: Create returned redirect (302)", $res->getStatus() === 302);
$createdCat = Database::fetchOne("SELECT * FROM dance_categories WHERE slug = 'qa-category-discipline'");
assertQA("DanceCategory: Persisted in MySQL", !empty($createdCat));
$catId = $createdCat['id'] ?? 0;

$res = dispatchPost("/admin/dance-categories/{$catId}/update", [
    'csrf_token' => $csrf,
    'name' => 'QA Category Discipline Edited',
    'slug' => 'qa-category-discipline',
    'description' => 'QA Category Description Updated',
    'sort_order' => 998,
    'is_active' => '1',
], $router);
assertQA("DanceCategory: Edit returned redirect (302)", $res->getStatus() === 302);
$updatedCat = Database::fetchOne("SELECT * FROM dance_categories WHERE id = :id", ['id' => $catId]);
assertQA("DanceCategory: Updates persisted in MySQL", $updatedCat['name'] === 'QA Category Discipline Edited');

$res = dispatchPost("/admin/dance-categories/{$catId}/delete", ['csrf_token' => $csrf], $router);
assertQA("DanceCategory: Delete returned redirect without 500 error", $res->getStatus() === 302);
assertQA("DanceCategory: Record removed from database", empty(Database::fetchOne("SELECT * FROM dance_categories WHERE id = :id", ['id' => $catId])));

// -----------------------------------------------------------------------------
// MODULE 04: DANCE STORIES (BLOGS)
// -----------------------------------------------------------------------------
echo "\n4. Testing Module: Dance Stories (Blog)\n";
$res = dispatchPost('/admin/blogs', [
    'csrf_token' => $csrf,
    'title' => 'QA Blog Title Story',
    'slug' => 'qa-blog-title-story',
    'category' => 'WORKSHOPS',
    'author_name' => 'QA Author',
    'excerpt' => 'QA Excerpt summary',
    'content' => '<p>QA Full body content for story</p>',
    'status' => 'PUBLISHED',
    'meta_title' => 'QA Blog Meta Title',
    'meta_description' => 'QA Blog Meta Description',
], $router);
assertQA("Blog: Create returned redirect (302)", $res->getStatus() === 302);
$createdBlog = Database::fetchOne("SELECT * FROM blog_posts WHERE slug = 'qa-blog-title-story'");
assertQA("Blog: Persisted in MySQL", !empty($createdBlog));
$bId = $createdBlog['id'] ?? 0;

$res = dispatchPost("/admin/blogs/{$bId}/update", [
    'csrf_token' => $csrf,
    'title' => 'QA Blog Title Story Edited',
    'slug' => 'qa-blog-title-story',
    'category' => 'CULTURE',
    'author_name' => 'QA Author Updated',
    'excerpt' => 'QA Excerpt summary updated',
    'content' => '<p>QA Content updated</p>',
    'status' => 'PUBLISHED',
    'meta_title' => 'QA Blog Meta Title Edited',
    'meta_description' => 'QA Blog Meta Description Edited',
], $router);
assertQA("Blog: Edit returned redirect (302)", $res->getStatus() === 302);
$updatedBlog = Database::fetchOne("SELECT * FROM blog_posts WHERE id = :id", ['id' => $bId]);
assertQA("Blog: Updates persisted in MySQL", $updatedBlog['title'] === 'QA Blog Title Story Edited' && $updatedBlog['category'] === 'CULTURE');

$res = dispatchPost("/admin/blogs/{$bId}/delete", ['csrf_token' => $csrf], $router);
assertQA("Blog: Delete returned redirect without 500 error", $res->getStatus() === 302);
assertQA("Blog: Cleanly deleted from database", empty(Database::fetchOne("SELECT * FROM blog_posts WHERE id = :id", ['id' => $bId])));

// -----------------------------------------------------------------------------
// MODULE 05: TESTIMONIALS
// -----------------------------------------------------------------------------
echo "\n5. Testing Module: Testimonials\n";
$res = dispatchPost('/admin/testimonials', [
    'csrf_token' => $csrf,
    'person_name' => 'QA Test Person',
    'relation_or_role' => 'Parent of Student',
    'review_text' => 'QA Exceptional training provided by academy',
    'rating' => 5,
    'sort_order' => 999,
    'is_active' => '1',
], $router);
assertQA("Testimonials: Create returned redirect (302)", $res->getStatus() === 302);
$createdTest = Database::fetchOne("SELECT * FROM testimonials WHERE person_name = 'QA Test Person'");
assertQA("Testimonials: Persisted in MySQL", !empty($createdTest));
$tId = $createdTest['id'] ?? 0;

$res = dispatchPost("/admin/testimonials/{$tId}/update", [
    'csrf_token' => $csrf,
    'person_name' => 'QA Test Person Edited',
    'relation_or_role' => 'Alumni Dancer',
    'review_text' => 'QA Review feedback updated',
    'rating' => 5,
    'sort_order' => 998,
    'is_active' => '1',
], $router);
assertQA("Testimonials: Edit returned redirect (302)", $res->getStatus() === 302);
$updatedTest = Database::fetchOne("SELECT * FROM testimonials WHERE id = :id", ['id' => $tId]);
assertQA("Testimonials: Updates persisted in MySQL", $updatedTest['person_name'] === 'QA Test Person Edited');

$res = dispatchPost("/admin/testimonials/{$tId}/delete", ['csrf_token' => $csrf], $router);
assertQA("Testimonials: Delete returned redirect without 500 error", $res->getStatus() === 302);
assertQA("Testimonials: Record removed from database", empty(Database::fetchOne("SELECT * FROM testimonials WHERE id = :id", ['id' => $tId])));

// -----------------------------------------------------------------------------
// MODULE 06: CUSTOM PAGES
// -----------------------------------------------------------------------------
echo "\n6. Testing Module: Custom Pages\n";
$res = dispatchPost('/admin/pages', [
    'csrf_token' => $csrf,
    'title' => 'QA Custom Page Test',
    'slug' => 'qa-custom-page-test',
    'subtitle' => 'QA Subtitle',
    'meta_title' => 'QA Page Meta Title',
    'meta_description' => 'QA Page Meta Description',
    'is_published' => '1',
], $router);
assertQA("Pages: Create returned redirect (302)", $res->getStatus() === 302);
$createdPage = Database::fetchOne("SELECT * FROM pages WHERE slug = 'qa-custom-page-test'");
assertQA("Pages: Persisted in MySQL", !empty($createdPage));
$pId = $createdPage['id'] ?? 0;

$res = dispatchPost("/admin/pages/{$pId}/update", [
    'csrf_token' => $csrf,
    'title' => 'QA Custom Page Test Edited',
    'slug' => 'qa-custom-page-test',
    'subtitle' => 'QA Subtitle Edited',
    'meta_title' => 'QA Page Meta Title Edited',
    'meta_description' => 'QA Page Meta Description Edited',
    'is_published' => '1',
], $router);
assertQA("Pages: Edit returned redirect (302)", $res->getStatus() === 302);
$updatedPage = Database::fetchOne("SELECT * FROM pages WHERE id = :id", ['id' => $pId]);
assertQA("Pages: Updates persisted in MySQL", $updatedPage['title'] === 'QA Custom Page Test Edited');

$res = dispatchPost("/admin/pages/{$pId}/delete", ['csrf_token' => $csrf], $router);
assertQA("Pages: Delete returned redirect without 500 error", $res->getStatus() === 302);
assertQA("Pages: Record removed from database", empty(Database::fetchOne("SELECT * FROM pages WHERE id = :id", ['id' => $pId])));

// -----------------------------------------------------------------------------
// MODULE 07: TOUR FLAGS
// -----------------------------------------------------------------------------
echo "\n7. Testing Module: Tour Flags\n";
$res = dispatchPost('/admin/tour-flags', [
    'csrf_token' => $csrf,
    'country_name' => 'QA Country Test',
    'country_code' => 'QA',
    'flag_url' => '/flags/qa.png',
    'year' => 2026,
    'sort_order' => 999,
    'is_active' => '1',
], $router);
assertQA("TourFlags: Create returned redirect (302)", $res->getStatus() === 302);
$createdFlag = Database::fetchOne("SELECT * FROM tour_flags WHERE country_name = 'QA Country Test'");
assertQA("TourFlags: Persisted in MySQL", !empty($createdFlag));
$fId = $createdFlag['id'] ?? 0;

$res = dispatchPost("/admin/tour-flags/{$fId}/update", [
    'csrf_token' => $csrf,
    'country_name' => 'QA Country Test Edited',
    'country_code' => 'QA',
    'flag_url' => '/flags/qa_edited.png',
    'year' => 2025,
    'sort_order' => 998,
    'is_active' => '1',
], $router);
assertQA("TourFlags: Edit returned redirect (302)", $res->getStatus() === 302);
$updatedFlag = Database::fetchOne("SELECT * FROM tour_flags WHERE id = :id", ['id' => $fId]);
assertQA("TourFlags: Updates persisted in MySQL", $updatedFlag && $updatedFlag['country_name'] === 'QA Country Test Edited');

$res = dispatchPost("/admin/tour-flags/{$fId}/delete", ['csrf_token' => $csrf], $router);
assertQA("TourFlags: Delete returned redirect without 500 error", $res->getStatus() === 302);
assertQA("TourFlags: Record removed from database", empty(Database::fetchOne("SELECT * FROM tour_flags WHERE id = :id", ['id' => $fId])));

// -----------------------------------------------------------------------------
// MODULE 08: CAMPUS BRANCHES
// -----------------------------------------------------------------------------
echo "\n8. Testing Module: Campus Branches\n";
$res = dispatchPost('/admin/branches', [
    'csrf_token' => $csrf,
    'branch_name' => 'QA Test Campus',
    'address_line_1' => 'QA Address 1',
    'city' => 'Ahmedabad',
    'state' => 'Gujarat',
    'phone_primary' => '+91 99999 99999',
    'email' => 'qa_campus@academy.com',
    'sort_order' => 999,
    'is_active' => '1',
], $router);
assertQA("Branches: Create returned redirect (302)", $res->getStatus() === 302);
$createdBranch = Database::fetchOne("SELECT * FROM branches WHERE branch_name = 'QA Test Campus'");
assertQA("Branches: Persisted in MySQL", !empty($createdBranch));
$brId = $createdBranch['id'] ?? 0;

$res = dispatchPost("/admin/branches/{$brId}/update", [
    'csrf_token' => $csrf,
    'branch_name' => 'QA Test Campus Edited',
    'address_line_1' => 'QA Address 1 Edited',
    'city' => 'Ahmedabad',
    'state' => 'Gujarat',
    'phone_primary' => '+91 88888 88888',
    'email' => 'qa_campus_edited@academy.com',
    'sort_order' => 998,
    'is_active' => '1',
], $router);
assertQA("Branches: Edit returned redirect (302)", $res->getStatus() === 302);
$updatedBranch = Database::fetchOne("SELECT * FROM branches WHERE id = :id", ['id' => $brId]);
assertQA("Branches: Updates persisted in MySQL", $updatedBranch && $updatedBranch['branch_name'] === 'QA Test Campus Edited');

$res = dispatchPost("/admin/branches/{$brId}/delete", ['csrf_token' => $csrf], $router);
assertQA("Branches: Delete returned redirect without 500 error", $res->getStatus() === 302);
assertQA("Branches: Record removed from database", empty(Database::fetchOne("SELECT * FROM branches WHERE id = :id", ['id' => $brId])));

// -----------------------------------------------------------------------------
// MODULE 09: USER MANAGEMENT (STAFF)
// -----------------------------------------------------------------------------
echo "\n9. Testing Module: Staff User Management\n";
$res = dispatchPost('/admin/users', [
    'csrf_token' => $csrf,
    'full_name' => 'QA Staff Member',
    'email' => 'qa_staff_test@academy.com',
    'role' => 'EDITOR',
    'password' => 'SafePass123!@#',
    'is_active' => '1',
], $router);
assertQA("Users: Create returned redirect (302)", $res->getStatus() === 302);
$createdUser = Database::fetchOne("SELECT * FROM users WHERE email = 'qa_staff_test@academy.com'");
assertQA("Users: Persisted in MySQL", !empty($createdUser));
$uId = $createdUser['id'] ?? 0;

$res = dispatchPost("/admin/users/{$uId}/update", [
    'csrf_token' => $csrf,
    'full_name' => 'QA Staff Member Edited',
    'role' => 'EDITOR',
    'is_active' => '1',
], $router);
assertQA("Users: Edit returned redirect (302)", $res->getStatus() === 302);
$updatedUser = Database::fetchOne("SELECT * FROM users WHERE id = :id", ['id' => $uId]);
assertQA("Users: Updates persisted in MySQL", $updatedUser['full_name'] === 'QA Staff Member Edited');

$res = dispatchPost("/admin/users/{$uId}/delete", ['csrf_token' => $csrf], $router);
assertQA("Users: Delete returned redirect without 500 error", $res->getStatus() === 302);
assertQA("Users: User removed from database", empty(Database::fetchOne("SELECT * FROM users WHERE id = :id", ['id' => $uId])));

// -----------------------------------------------------------------------------
// MODULE 10: AUDIT LOG VERIFICATION
// -----------------------------------------------------------------------------
echo "\n10. Testing Module: Audit Logs Recording\n";
$auditCount = Database::fetchOne("SELECT COUNT(*) as c FROM audit_logs")['c'] ?? 0;
assertQA("AuditLogs: System recorded CRUD actions in audit_logs", $auditCount > 0);

// Clear runtime caches
CacheService::flush();
SeoService::clearCache();

echo "\n====================================================================\n";
echo "ADMIN E2E CRUD QA SUMMARY: {$totalQA} Tests | {$passedQA} Passed | {$failedQA} Failed\n";
echo "====================================================================\n";

if ($failedQA > 0) {
    exit(1);
}
