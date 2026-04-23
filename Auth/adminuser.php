<?php
require "db.php";

$username = "admin";
$password = password_hash("123456", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "User created";
?>