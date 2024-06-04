<?php
require_once 'config.php';
header('Content-Type: application/json');

$sql = "SELECT video_path FROM videos WHERE visibility = 'public'";

$result = $link->query($sql);
$videos = [];
while ($row = $result->fetch_assoc()) {
    $videos[] = 'M7zm/' . $row['video_path'];
}

$link->close();
echo json_encode($videos);
?>
