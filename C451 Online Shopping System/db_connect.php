<?php
$host = getenv('DB_HOST') ?: '127.0.0.1';
$db = getenv('DB_NAME') ?: 'info_c451_online_shopping_system';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '1234qwer';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database connection failed. Please try again later.");
}
?>
