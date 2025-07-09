<?php
$host = 'training2025-db-instance-1.c25mkwu8gg8k.us-east-1.rds.amazonaws.com';   
$db   = 'salesdb';
$user = 'karpuz';     
$pass = 'training2025-karpuz';     
$port = '5432';        

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connecting error: " . $e->getMessage());
}
?>
