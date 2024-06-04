<?php
require_once 'config.php';
session_start();
header('Content-Type: application/json');

$sender_id = $_SESSION['id'];
$receiver_id = $_POST['user_id'];

$sql = "SELECT m.message, m.timestamp, m.sender_id, u.fullname, u.profile_image 
        FROM messages m
        JOIN users u ON u.id = m.sender_id
        WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?) 
        ORDER BY m.timestamp ASC";
$stmt = $link->prepare($sql);
$stmt->bind_param("iiii", $sender_id, $receiver_id, $receiver_id, $sender_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>