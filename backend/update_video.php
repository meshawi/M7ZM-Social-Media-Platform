<?php
header('Content-Type: application/json');
require_once 'config.php';

session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['videoId'])) {
    $videoId = intval($_POST['videoId']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $visibility = $_POST['visibility'];
    $tags = $_POST['tags'] ?? [];
    $userId = $_SESSION['id'];

    $link->begin_transaction();

    try {
        $stmt = $link->prepare("UPDATE videos SET title = ?, description = ?, visibility = ? WHERE id = ? AND creator_id = ?");
        $stmt->bind_param("sssii", $title, $description, $visibility, $videoId, $userId);
        $stmt->execute();
        $stmt->close();

        if (isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnailPath = '../storage/profile_images/' . basename($_FILES['thumbnail']['name']);
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailPath);

            $stmt = $link->prepare("UPDATE videos SET thumbnail_path = ? WHERE id = ? AND creator_id = ?");
            $stmt->bind_param("sii", $thumbnailPath, $videoId, $userId);
            $stmt->execute();
            $stmt->close();
        }

        if (!empty($tags)) {
            $stmt = $link->prepare("DELETE FROM video_tags WHERE video_id = ?");
            $stmt->bind_param("i", $videoId);
            $stmt->execute();
            $stmt->close();

            $stmt = $link->prepare("INSERT INTO video_tags (video_id, tag_id) VALUES (?, ?)");
            foreach ($tags as $tagId) {
                $stmt->bind_param("ii", $videoId, $tagId);
                $stmt->execute();
            }
            $stmt->close();
        }

        $link->commit();
        echo json_encode(['success' => true, 'message' => 'Video updated successfully']);
    } catch (Exception $e) {
        $link->rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to update video: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or missing data.']);
}
?>
