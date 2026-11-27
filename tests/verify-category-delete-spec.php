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
use App\Controllers\Admin\DanceCategoriesController;

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');

Session::start();
Session::set('user_id', 1);
Session::set('role', 'SUPER_ADMIN');

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

echo "Starting Dance Category Deletion Fix Verification Spec...\n\n";

$catCtrl = new DanceCategoriesController();

// 1. Create a test category
$testCatName = "Test Category Deletion " . time();
$createReq = new Request([], [
    'name' => $testCatName,
    'slug' => 'test-cat-del-' . time(),
    'is_active' => '1',
    'csrf_token' => 'dummy',
], ['REQUEST_METHOD' => 'POST']);

$catCtrl->store($createReq);
$createdCat = Database::fetchOne("SELECT * FROM dance_categories WHERE name = :n", ['n' => $testCatName]);
assertCondition(!empty($createdCat), "Test category created in database");
$catId = (int)$createdCat['id'];

// 2. Assign a dance_form to this category (simulating the issue)
Database::query("INSERT INTO dance_forms (category_id, name, slug, created_at, updated_at) VALUES (:cid, :name, :slug, NOW(), NOW())", [
    'cid' => $catId,
    'name' => 'Form for ' . $testCatName,
    'slug' => 'form-del-' . time(),
]);
$formCount = Database::fetchColumn("SELECT COUNT(*) FROM dance_forms WHERE category_id = :cid", ['cid' => $catId]);
assertCondition((int)$formCount === 1, "Dance form assigned to test category");

// 3. Assign a gallery item to this category
Database::query("INSERT INTO gallery_items (category_id, title, image_url, created_at, updated_at) VALUES (:cid, :title, '/test.jpg', NOW(), NOW())", [
    'cid' => $catId,
    'title' => 'Photo for ' . $testCatName,
]);
$galleryCount = Database::fetchColumn("SELECT COUNT(*) FROM gallery_items WHERE category_id = :cid", ['cid' => $catId]);
assertCondition((int)$galleryCount === 1, "Gallery item assigned to test category");

// 4. Now execute delete on the category
$delReq = new Request([], ['csrf_token' => 'dummy'], ['REQUEST_METHOD' => 'POST']);
$delResp = $catCtrl->delete($delReq, ['id' => $catId]);

assertCondition($delResp->getStatus() === 302, "Category delete returns HTTP 302 redirect");

// 5. Verify the category was successfully deleted
$catAfter = Database::fetchOne("SELECT * FROM dance_categories WHERE id = :id", ['id' => $catId]);
assertCondition(empty($catAfter), "Category successfully deleted from dance_categories");

// 6. Verify associated dance forms were cleaned up
$formsAfter = Database::fetchColumn("SELECT COUNT(*) FROM dance_forms WHERE category_id = :id", ['id' => $catId]);
assertCondition((int)$formsAfter === 0, "Associated dance forms cleanly deleted");

// 7. Verify gallery items had category_id set to NULL without being deleted
$galleryAfter = Database::fetchOne("SELECT * FROM gallery_items WHERE title = :t", ['t' => 'Photo for ' . $testCatName]);
assertCondition(!empty($galleryAfter) && $galleryAfter['category_id'] === null, "Gallery item preserved and category_id set to NULL");

// Clean up test gallery item
Database::query("DELETE FROM gallery_items WHERE title = :t", ['t' => 'Photo for ' . $testCatName]);

echo "\n============================================\n";
echo "Total Passes: {$passes}\n";
echo "Total Errors: " . count($errors) . "\n";
if (empty($errors)) {
    echo "ALL CATEGORY DELETION TESTS PASSED! 100% SUCCESS\n";
    exit(0);
} else {
    echo "FAILURES ENCOUNTERED:\n";
    foreach ($errors as $e) {
        echo " - {$e}\n";
    }
    exit(1);
}
