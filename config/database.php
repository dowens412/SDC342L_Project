<?php
// Database connection settings for MAMP
$host = "127.0.0.1";
$dbname = "complaint_system";
$username = "root";
$password = "root";
$port = 8889;

try {
    $db = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>