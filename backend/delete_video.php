<?php
require_once 'config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $videoId = $_POST['id'];
    $userId = $_SESSION['id'];

    $sql = "DELETE FROM videos WHERE id = ? AND creator_id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $videoId, $userId);
        mysqli_stmt_execute($stmt);
        
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['message'] = 'Video deleted successfully!';
        } else {
            $_SESSION['message'] = 'No video found or you do not have permission to delete this video.';
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['message'] = 'Database preparation error.';
    }
    mysqli_close($link);
} else {
    $_SESSION['message'] = 'Invalid request or missing ID.';
}
header('Location: ../pages/my_videos.php');
exit;
?>
