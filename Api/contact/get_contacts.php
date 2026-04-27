<?php 
require "../../config/db.php";

header("Content-type: application/json");

$stmt = $pdo->query("SELECT * FROM contacts");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "success" => true,
    "data" => $data
]);

?>