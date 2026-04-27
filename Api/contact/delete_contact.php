<?php
require '../config/db.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;

if (!$id) {
    echo json_encode(["error" => "ID required"]);
    exit();
}

$stmt = $pdo->prepare("DELETE FROM contacts WHERE id=?");
$stmt->execute([$id]);

echo json_encode(["success" => true]);