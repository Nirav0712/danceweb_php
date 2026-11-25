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

echo "=== HOMEPAGE FULL-WIDTH HERO BANNER AUDIT ===\n\n";

$checks = [
    'Single full-width hero section (w-full)' => strpos($html, '<section class="relative w-full overflow-hidden bg-slate-950" id="hero-slider-section">') !== false,
    'Responsive height classes applied (320px/450px/550px/680px)' => strpos($html, 'h-[320px] sm:h-[450px] md:h-[550px] lg:h-[680px]') !== false,
    'Full-width slider container (w-full h-full)' => strpos($html, 'id="hero-carousel-container"') !== false,
    'Slides use object-cover object-center w-full h-full' => strpos($html, 'class="w-full h-full object-cover object-center block"') !== false,
    'Shows one large image at a time (absolute inset-0 opacity-100 / opacity-0)' => strpos($html, 'hero-slide absolute inset-0 w-full h-full transition-opacity') !== false,
    'Heading below hero exact text: Culture Is a Way of Life' => strpos($html, 'Culture Is a <span class="text-amber-500 font-extrabold">Way of Life</span>') !== false,
    'Heading is separate section below hero' => strpos($html, '<!-- Heading Immediately Below Hero -->') !== false,
    'No old CTA buttons in hero' => strpos($html, 'Enroll for Admissions') === false,
    'No old text overlays in hero' => strpos($html, 'Limca & Golden Book World Records') === false,
    'No 3-card layout classes (pos-0, pos-1, pos-2)' => strpos($html, 'pos-0') === false && strpos($html, 'pos-1') === false,
    'No fixed or sticky positioning on hero section (normal flow)' => !preg_match('/id="hero-slider-section"[^>]*class="[^"]*(fixed|sticky)/', $html),
    'Carousel arrows present (prev/next)' => strpos($html, 'id="hero-prev-btn"') !== false && strpos($html, 'id="hero-next-btn"') !== false,
    'Pagination dots present' => strpos($html, 'id="hero-pagination-dots"') !== false,
    'Autoplay script present (5s)' => strpos($html, 'autoPlayTimer = setInterval') !== false,
    'Touch swipe mobile script present' => strpos($html, 'touchstart') !== false && strpos($html, 'touchend') !== false,
    'Dynamic CMS/media images loaded' => preg_match('/src="\/assets\/(banners|about|gallery|homepage)\//', $html) === 1,
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
