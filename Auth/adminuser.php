<?php
require "../config/db.php";

$username = "admin";
$password = password_hash("123456", PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES ( ?, ?, ?)");
$stmt->execute([$username,  $password, "admin"]);

echo "User created";
?>