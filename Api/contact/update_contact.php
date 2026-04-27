<?php 
require "./../config/db.php";
header("Content-Type: application/json");
 $id = $_POST['id'] ?? null;;
 IF (!$id) {
    echo json_encode(["error" => "ID is required"]);
    exit();
 }
$name = $_POST['name'];
$position = $_POST['position'];
$email = $_POST['email'];
$phone = $_POST['phone_number'];

 $stmt = $pdo->prepare("
     UPDATE contacts SET name = ?, position = ?, email = ?, phone_number = ? WHERE id = ? ");
$stmt->execute([$name, $position, $email, $phone, $id]);
echo json_encode([
    "success" => true,
    "message" => "Contact updated successfully"
]);



?>