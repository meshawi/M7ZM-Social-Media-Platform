<?php
require_once 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $videoId = intval($_GET['id']);

    $response = ['video' => [], 'tags' => [], 'allTags' => []];
    
    // Fetch video details
    $stmt = $link->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->bind_param("i", $videoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $response['video'] = $result->fetch_assoc();
    $stmt->close();

    // Fetch all tags
    $stmt = $link->prepare("SELECT id, name FROM tags");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($tag = $result->fetch_assoc()) {
        $response['allTags'][] = $tag;
    }
    $stmt->close();

    // Fetch tags for the video
    $stmt = $link->prepare("SELECT tag_id FROM video_tags WHERE video_id = ?");
    $stmt->bind_param("i", $videoId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($tag = $result->fetch_assoc()) {
        $response['tags'][] = $tag['tag_id'];
    }
    $stmt->close();

    echo json_encode($response);
}
