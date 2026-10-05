<?php
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    $sql = file_get_contents(__DIR__ . '/seed_sample_data.sql');
    $pdo->exec($sql);
    echo "SEED DATA INSERTED SUCCESSFULLY!" . PHP_EOL;
} catch (Exception $e) {
    echo "SEED ERROR: " . $e->getMessage() . PHP_EOL;
}
