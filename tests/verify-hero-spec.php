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

Env::load(ROOT_DIR . '/.env');
Config::load(ROOT_DIR . '/config');
Logger::init(ROOT_DIR . '/storage');
View::init(ROOT_DIR . '/resources/views');

$router = new Router();
require ROOT_DIR . '/routes/web.php';

$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$req = new Request();
$res = $router->dispatch($req);

$html = $res->getBody();

echo "=== HOMEPAGE HERO VISUAL SPECIFICATION AUDIT ===\n\n";

$checks = [
    'Hero heading exact text: Culture Is a Way of Life' => strpos($html, 'Culture Is a <span class="text-amber-500 font-extrabold">Way of Life</span>') !== false,
    'No old CTA button text in hero' => strpos($html, 'Enroll for Admissions') === false,
    'No old subtitle badges in hero' => strpos($html, 'Limca & Golden Book World Records') === false,
    'Hero carousel container present' => strpos($html, 'id="hero-carousel-container"') !== false,
    'Hero slider track present' => strpos($html, 'id="hero-slider-track"') !== false,
    'Purple-to-pink gradient border style present' => strpos($html, 'from-purple-600 via-fuchsia-500 to-pink-500') !== false,
    'Carousel navigation arrows (prev/next) present' => strpos($html, 'id="hero-prev-btn"') !== false && strpos($html, 'id="hero-next-btn"') !== false,
    'Carousel pagination dots container present' => strpos($html, 'id="hero-pagination-dots"') !== false,
    'Desktop 3-image layout proportions (28% : 28% : 44%)' => strpos($html, '.hero-carousel-item.pos-0 { width: 28%; }') !== false && strpos($html, '.hero-carousel-item.pos-2 { width: 44%; }') !== false,
    'Tablet 2-image layout (50% each)' => strpos($html, '.hero-carousel-item { width: 50% !important; }') !== false,
    'Mobile 1-image full width (100%)' => strpos($html, '.hero-carousel-item { width: 100% !important; }') !== false,
    'Autoplay mechanism present (5s interval)' => strpos($html, 'autoPlayTimer = setInterval') !== false,
    'Mobile touch swipe event listeners present' => strpos($html, 'touchstart') !== false && strpos($html, 'touchend') !== false,
    'CMS images / Media assets dynamic population' => preg_match('/src="\/assets\/(banners|about|gallery|homepage)\//', $html) === 1,
];

$pass = 0;
$fail = 0;
foreach ($checks as $name => $ok) {
    if ($ok) {
        $pass++;
        echo "  [PASS] {$name}\n";
    } else {
        $fail++;
        echo "  [FAIL] {$name}\n";
    }
}

echo "\nSummary: {$pass} Passed | {$fail} Failed\n";
exit($fail === 0 ? 0 : 1);
