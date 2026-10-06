<?php
require_once __DIR__ . '/../core/Env.php';
Env::load();

define('APP_NAME', Env::get('APP_NAME', 'Jejak Muslim Indonesia'));
define('APP_ENV', Env::get('APP_ENV', 'development')); // 'development' or 'production'

// Dynamic BASE_URL calculation with .env override support
$envBaseUrl = Env::get('BASE_URL', '');
if (!empty($envBaseUrl)) {
    define('BASE_URL', rtrim($envBaseUrl, '/'));
} else {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    
    // Automatically detect script directory path relative to document root
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $baseSubdir = ($scriptDir === '/' || $scriptDir === '\\' || $scriptDir === '.') ? '' : rtrim($scriptDir, '/');
    
    define('BASE_URL', $scheme . '://' . $host . $baseSubdir);
}

define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');
define('MAX_FILE_SIZE', 2097152); // 2MB in bytes
define('DEFAULT_TIMEZONE', 'Asia/Jakarta');
define('ITEMS_PER_PAGE', 10);

date_default_timezone_set(DEFAULT_TIMEZONE);
