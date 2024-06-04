<?php
require_once "../backend/config.php";
session_start();

$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

if ($userId <= 0) {
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

$sql = "SELECT fullname, bio, 
           (SELECT COUNT(*) FROM videos WHERE creator_id = ?) as videoCount, 
           (SELECT COUNT(*) FROM likes WHERE user_id = ? AND liked = 1) as likesCount 
        FROM users WHERE id = ?";

$stmt = $link->prepare($sql);
if (!$stmt) {
    echo json_encode(['error' => 'Database prepare error: ' . $link->error]);
    exit;
}

$stmt->bind_param("iii", $userId, $userId, $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($userDetails = $result->fetch_assoc()) {
    echo json_encode($userDetails);
} else {
    echo json_encode(['error' => 'User not found']);
}

$stmt->close();
$link->close();
?>
