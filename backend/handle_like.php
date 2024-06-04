<?php
require_once "../backend/config.php";
session_start();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'An error occurred'];

if (!isset($_SESSION['id'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['video_id']) && isset($_POST['liked'])) {
    $videoId = $_POST['video_id'];
    $userId = $_SESSION['id'];
    $liked = $_POST['liked'] === 'true' ? 1 : 0;

    $checkSql = "SELECT id FROM video_likes WHERE video_id = ? AND user_id = ?";
    $stmt = $link->prepare($checkSql);
    $stmt->bind_param("ii", $videoId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->fetch_assoc()) {
        $updateSql = "UPDATE video_likes SET liked = ? WHERE video_id = ? AND user_id = ?";
        $updateStmt = $link->prepare($updateSql);
        $updateStmt->bind_param("iii", $liked, $videoId, $userId);
        $updateStmt->execute();
        $updateStmt->close();
        $response['success'] = true;
        $response['message'] = 'Your response has been updated';
    } else {
        $insertSql = "INSERT INTO video_likes (video_id, user_id, liked) VALUES (?, ?, ?)";
        $insertStmt = $link->prepare($insertSql);
        $insertStmt->bind_param("iii", $videoId, $userId, $liked);
        $insertStmt->execute();
        $insertStmt->close();
        $response['success'] = true;
        $response['message'] = 'Your response has been recorded';
    }
} else {
    $response['message'] = 'Invalid request or missing parameters';
}

echo json_encode($response);
$link->close();
?>
