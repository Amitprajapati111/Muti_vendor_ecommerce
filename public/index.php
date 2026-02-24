<?php
// Front Controller

declare(strict_types=1);

// Paths
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . DIRECTORY_SEPARATOR . 'app');

date_default_timezone_set('UTC');

// Composer not used; implement simple autoloader
spl_autoload_register(function ($class) {
    $paths = [
        APP_PATH . '/core/' . $class . '.php',
        APP_PATH . '/controllers/' . $class . '.php',
        APP_PATH . '/models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Config and helpers
require_once BASE_PATH . '/config/config.php';
require_once APP_PATH . '/helpers/helpers.php';

// Sessions
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize router and dispatch
try {
    $router = new Router();
    $router->dispatch();
} catch (Throwable $e) {
    if (defined('APP_DEBUG') && APP_DEBUG) {
        http_response_code(500);
        echo '<h1>Application Error</h1>';
        echo '<pre>' . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . "\n\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    } else {
        http_response_code(500);
        echo 'Something went wrong. Please try again later.';
    }
}
