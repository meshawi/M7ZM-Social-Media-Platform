<?php
require_once 'config.php';
session_start();
header('Content-Type: application/json');

$current_user_id = $_SESSION['id'];

$sql = "SELECT id, username, fullname, profile_image, status FROM users WHERE id != ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>