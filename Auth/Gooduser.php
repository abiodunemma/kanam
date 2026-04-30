<?php  
require "../config/db.php";

$username = "abbey";
$password = password_hash("1111111111", PASSWORD_DEFAULT);
$role = "user";

$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
$stmt->execute([$username,  $password, $role]);

?> 