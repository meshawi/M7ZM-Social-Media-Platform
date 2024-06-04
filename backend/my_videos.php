<?php
require_once 'config.php';

$user_id = $_SESSION['id'] ?? 0;

$sql = "SELECT v.*, GROUP_CONCAT(t.name SEPARATOR ', ') AS tags 
        FROM videos v 
        LEFT JOIN video_tags vt ON v.id = vt.video_id 
        LEFT JOIN tags t ON vt.tag_id = t.id
        WHERE v.creator_id = ? 
        GROUP BY v.id
        ORDER BY v.created_at DESC";

if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $videos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_stmt_close($stmt);
} else {
    $videos = [];
}
mysqli_close($link);
?>
