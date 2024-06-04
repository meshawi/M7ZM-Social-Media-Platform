<?php
require_once "../backend/config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['id'];

$sql = "SELECT v.*, u.fullname AS creator_name, u.profile_image AS creator_profile_image
        FROM favorites f
        JOIN videos v ON f.video_id = v.id
        JOIN users u ON v.creator_id = u.id
        WHERE f.user_id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$videos = [];
while ($video = $result->fetch_assoc()) {
    $videos[] = $video;
}
$stmt->close();
$link->close();

echo json_encode($videos);  
?>
