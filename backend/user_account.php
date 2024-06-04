<?php
session_start();
require_once("../backend/config.php");

function fetchUserVideos($user_id) {
    global $link;
    $videos = [];
    $sql = "SELECT v.*, GROUP_CONCAT(t.name) AS tags 
            FROM videos v 
            LEFT JOIN video_tags vt ON v.id = vt.video_id 
            LEFT JOIN tags t ON vt.tag_id = t.id 
            WHERE v.creator_id = ? 
            AND (v.visibility = 'public' OR v.visibility = 'private')
            GROUP BY v.id";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $videos[] = $row;
        }
        mysqli_stmt_close($stmt);
    }
    return $videos;
}

if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} elseif(isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
} else {
    exit; // Handle the case where user ID is not provided
}

$sql = "SELECT u.fullname, u.bio, u.profile_image, COUNT(DISTINCT v.id) AS video_count, COUNT(DISTINCT l.video_id) AS likes_count
        FROM users u
        LEFT JOIN videos v ON v.creator_id = u.id
        LEFT JOIN video_likes l ON l.user_id = u.id AND l.liked = 1
        WHERE u.id = ?
        GROUP BY u.id";

if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userData = $result->fetch_assoc();

    if ($userData) {
        if (empty($userData['bio'])) {
            $userData['bio'] = 'No bio provided.';
        }

        $videos = fetchUserVideos($user_id);
        mysqli_stmt_close($stmt);
    } else {
        exit; // Handle the case where user is not found
    }
} else {
    exit; // Handle database error
}

mysqli_close($link);
?>
