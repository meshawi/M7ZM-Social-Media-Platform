<?php
require_once 'config.php';
require_once('../lib/getID3/getid3/getid3.php');

header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['error' => 'Unauthorized access.']);
    exit;
}

$sql = "SELECT v.*, u.fullname AS creator_name, u.profile_image AS creator_profile_image, GROUP_CONCAT(t.name) AS tags
        FROM videos v
        JOIN users u ON v.creator_id = u.id
        LEFT JOIN video_tags vt ON v.id = vt.video_id
        LEFT JOIN tags t ON vt.tag_id = t.id
        WHERE v.visibility IN ('private', 'public')
        GROUP BY v.id";

$result = $link->query($sql);
$videos = [];

$getID3 = new getID3;

while ($row = $result->fetch_assoc()) {
    $row['tags'] = explode(',', $row['tags'] ?? '');

    $videoFile = __DIR__ . '/' . $row['video_path'];
    $fileInfo = $getID3->analyze($videoFile);

    $duration = $fileInfo['playtime_string'] ?? 'Unknown';
    $resolution = isset($fileInfo['video']['resolution_x']) ? $fileInfo['video']['resolution_x'] . 'x' . $fileInfo['video']['resolution_y'] : 'Unknown';
    $bitrate = isset($fileInfo['bitrate']) ? $fileInfo['bitrate'] / 1000 . ' kb/s' : 'Unknown';
    $size = isset($fileInfo['filesize']) ? $fileInfo['filesize'] : 'Unknown';

    $row['duration'] = $duration;
    $row['resolution'] = $resolution;
    $row['size'] = $size;
    $row['bitrate'] = $bitrate;

    $videos[] = $row;
}

$link->close();
echo json_encode($videos);
?>
