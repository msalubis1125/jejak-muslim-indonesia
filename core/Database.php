<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log('Database Connection Error: ' . $e->getMessage());

            if (defined('APP_ENV') && APP_ENV === 'development') {
                die('Database Connection Error: ' . htmlspecialchars($e->getMessage()));
            } else {
                http_response_code(500);
                echo '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>500 - Kesalahan Layanan</title><style>body{font-family:sans-serif;text-align:center;padding:50px;color:#333}h1{color:#e11d48}</style></head><body><h1>500 - Terjadi Kesalahan Layanan</h1><p>Sistem sedang mengalami kendala koneksi data. Silakan coba beberapa saat lagi.</p></body></html>';
                exit;
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
