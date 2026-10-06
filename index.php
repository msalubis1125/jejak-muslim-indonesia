<?php
// Define base path
define('ROOT_PATH', __DIR__);

// Load Environment Loader first
require_once ROOT_PATH . '/core/Env.php';
Env::load(ROOT_PATH . '/.env');

// Load configurations
require_once ROOT_PATH . '/config/app.php';
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/config/constants.php';

// Load core classes
require_once ROOT_PATH . '/core/Session.php';
require_once ROOT_PATH . '/core/Database.php';
require_once ROOT_PATH . '/core/Model.php';
require_once ROOT_PATH . '/core/Controller.php';
require_once ROOT_PATH . '/core/App.php';
require_once ROOT_PATH . '/core/CSRF.php';
require_once ROOT_PATH . '/core/Auth.php';
require_once ROOT_PATH . '/core/Validator.php';
require_once ROOT_PATH . '/core/RateLimiter.php';
require_once ROOT_PATH . '/core/FileUploader.php';

// Start Session
Session::start();

// Error reporting based on environment
if (defined('APP_ENV') && APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

// Initialize application
$app = new App();
