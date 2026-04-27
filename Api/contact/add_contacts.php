<?php 
require "../config/db.php";
header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request method"]);
    exit();
}
$name = $_POST['name'] ?? '';
$position = $_POST['position'] ?? '';
$email = $_POST['email'] ?? '';
$phone_number = $_POST['phone_number'] ?? '';

if ( !$name || !$position || !$email || !$phone_number) {
    echo json_encode(["error" => "All fields are required"]);
    exit();
}
$stmt = $pdo->prepare("INSERT INTO contacts (name, position, email, phone_number) VALUES (?, ?, ?, ?)");
$stmt->execute([$name, $position, $email, $phone_number]);
echo json_encode([
    "SUCCESS" => true,
    "message" => "Contact added successfully"
    ]);
?>