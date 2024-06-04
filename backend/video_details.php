<?php
require_once "config.php";
session_start();

$videoId = isset($_GET['id']) ? $_GET['id'] : die('Video ID is required');

if (!isset($_SESSION['viewed_videos'])) {
    $_SESSION['viewed_videos'] = [];
}

$sql = "SELECT v.*, u.fullname AS creator_name, u.profile_image AS creator_profile_image,
        SUM(CASE WHEN vl.liked = 1 THEN 1 ELSE 0 END) AS like_count,
        SUM(CASE WHEN vl.liked = 0 THEN 1 ELSE 0 END) AS dislike_count
        FROM videos v
        JOIN users u ON v.creator_id = u.id
        LEFT JOIN video_likes vl ON v.id = vl.video_id
        WHERE v.id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $videoId);
$stmt->execute();
$result = $stmt->get_result();
$video = $result->fetch_assoc();

if (!$video) {
    die('Video not found.');
}

if (!in_array($videoId, $_SESSION['viewed_videos'])) {
    $updateSql = "UPDATE videos SET view_count = view_count + 1 WHERE id = ?";
    $updateStmt = $link->prepare($updateSql);
    $updateStmt->bind_param("i", $videoId);
    $updateStmt->execute();
    $updateStmt->close();

    $_SESSION['viewed_videos'][] = $videoId;
    $video['view_count'] += 1;
}

$comments = [];

$commentQuery = "SELECT c.*, u.fullname AS username FROM comments c JOIN users u ON c.user_id = u.id WHERE video_id = ?";
$commentStmt = $link->prepare($commentQuery);
$commentStmt->bind_param("i", $videoId);
$commentStmt->execute();
$commentsResult = $commentStmt->get_result();
while ($comment = $commentsResult->fetch_assoc()) {
    $comments[] = $comment;
}
$commentStmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $commentText = trim($_POST['comment']);
    if (!empty($commentText)) {
        $insertSql = "INSERT INTO comments (video_id, user_id, comment) VALUES (?, ?, ?)";
        $insertStmt = $link->prepare($insertSql);
        $insertStmt->bind_param("iis", $videoId, $_SESSION['id'], $commentText);
        $insertStmt->execute();
        $insertStmt->close();
        header("Location: video_details.php?id=$videoId");
        exit;
    }
}

$favSql = "SELECT id FROM favorites WHERE video_id = ? AND user_id = ?";
$favStmt = $link->prepare($favSql);
$favStmt->bind_param("ii", $videoId, $_SESSION['id']);
$favStmt->execute();
$isFavorite = $favStmt->get_result()->fetch_assoc();
$favStmt->close();

$stmt->close();
?>
