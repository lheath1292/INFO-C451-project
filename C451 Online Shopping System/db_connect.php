<?php
$host = '127.0.0.1';  // MySQL server (localhost)
$db = 'info_c451_online_shopping_system'; // Database name
$user = 'root'; // MySQL user (default is 'root' on local)
$pass = '1234qwer'; // MySQL password (leave empty if not set)

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
    echo "Connected successfully!";
} catch (PDOException $e) {
    // If connection fails, catch the exception and show the error message
    echo "Connection failed: " . $e->getMessage();
}
?>
