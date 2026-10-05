<?php
define('APP_NAME', 'Jejak Muslim Indonesia');
define('APP_ENV', 'development'); // change to production for live
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('BASE_URL', $scheme . '://' . $host . '/jejak-muslim-indonesia');
define('UPLOAD_PATH', ROOT_PATH . '/public/uploads');
define('MAX_FILE_SIZE', 2097152); // 2MB in bytes
define('DEFAULT_TIMEZONE', 'Asia/Jakarta');
define('ITEMS_PER_PAGE', 10);

date_default_timezone_set(DEFAULT_TIMEZONE);
