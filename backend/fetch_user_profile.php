<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['id'];

$sql = "SELECT u.fullname, u.bio, u.profile_image, COUNT(DISTINCT v.id) AS video_count, COUNT(DISTINCT l.video_id) AS likes_count
        FROM users u
        LEFT JOIN videos v ON v.creator_id = u.id
        LEFT JOIN video_likes l ON l.user_id = u.id AND l.liked = 1
        WHERE u.id = ?
        GROUP BY u.id";

if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userData = $result->fetch_assoc();

    if ($userData) {
        if (empty($userData['bio'])) {
            $userData['bio'] = 'No bio provided.';
        }
        
        echo json_encode(['success' => true, 'data' => $userData]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
mysqli_close($link);
?>
