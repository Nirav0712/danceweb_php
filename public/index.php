<?php

declare(strict_types=1);

// Unified Front Controller
if (!defined('APP_START')) {
    define('APP_START', microtime(true));
}
if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', dirname(__DIR__));
}

// Autoloader for App\* classes
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = ROOT_DIR . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Env;
use App\Core\Config;
use App\Core\Logger;
use App\Core\View;
use App\Core\Session;
use App\Core\Request;
use App\Core\Router;
use App\Core\Response;

try {
    // 1. Load Environment Variables
    Env::load(ROOT_DIR . '/.env');

    // 2. Load Application Config
    Config::load(ROOT_DIR . '/config');

    // 3. Initialize Logger & Views
    Logger::init(ROOT_DIR . '/storage');
    View::init(ROOT_DIR . '/resources/views');

    // 4. Start Secure Session
    Session::start();

    // 5. Initialize Router & Routes
    $router = new Router();
    require ROOT_DIR . '/routes/web.php';

    // 6. Handle Incoming Request
    $request = new Request();
    $response = $router->dispatch($request);
    $response->send();

} catch (\Throwable $e) {
    Logger::error('Unhandled Exception: ' . $e->getMessage(), [
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString(),
    ]);

    http_response_code(500);
    $debug = Config::get('app.debug', false);

    if ($debug) {
        echo '<h1>500 Internal Server Error</h1>';
        echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
        echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile(), ENT_QUOTES, 'UTF-8') . ' : ' . $e->getLine() . '</p>';
        echo '<pre>' . htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8') . '</pre>';
    } else {
        echo '<h1>500 Internal Server Error</h1>';
        echo '<p>An unexpected error occurred. Please try again later.</p>';
    }
}
