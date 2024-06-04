<?php
require_once "../backend/config.php";
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$response = ['success' => false, 'message' => '', 'action' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_id'])) {
    $videoId = $_POST['video_id'];
    $userId = $_SESSION['id'];

    // Check if already favorited
    $checkSql = "SELECT id FROM favorites WHERE video_id = ? AND user_id = ?";
    $stmt = $link->prepare($checkSql);
    $stmt->bind_param("ii", $videoId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        // Remove from favorites
        $deleteSql = "DELETE FROM favorites WHERE id = ?";
        $deleteStmt = $link->prepare($deleteSql);
        $deleteStmt->bind_param("i", $row['id']);
        $deleteStmt->execute();
        $deleteStmt->close();
        $response['success'] = true;
        $response['message'] = 'Video removed from favorites';
        $response['action'] = 'add';
    } else {
        // Add to favorites
        $insertSql = "INSERT INTO favorites (video_id, user_id) VALUES (?, ?)";
        $insertStmt = $link->prepare($insertSql);
        $insertStmt->bind_param("ii", $videoId, $userId);
        $insertStmt->execute();
        $insertStmt->close();
        $response['success'] = true;
        $response['message'] = 'Video added to favorites';
        $response['action'] = 'remove';
    }
    $stmt->close();
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
$link->close();
?>
