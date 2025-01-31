<?php
$host = "127.0.0.1"; // Your database host (localhost)
$dbname = "procyon2025"; // Your database name
$username = "root"; // Your MySQL username (default is 'root' for XAMPP)
$password = ""; // Your MySQL password (leave empty for default XAMPP)

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set error mode to Exception for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Stop execution and show error if the connection fails
    die("Connection failed: " . $e->getMessage());
}
?>
