<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $visibility = $_POST['visibility'];
    $creator_id = $_SESSION['id'];

    $videoPath = "../storage/videos/" . basename($_FILES['video']['name']);
    if (move_uploaded_file($_FILES['video']['tmp_name'], $videoPath)) {
        $thumbnailPath = null;

        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
            $allowedFormats = ['jpeg', 'jpg', 'png', 'gif'];
            $thumbnailExtension = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            
            if (!in_array($thumbnailExtension, $allowedFormats)) {
                echo "Error: Invalid thumbnail image format. Allowed formats are JPEG, JPG, PNG, and GIF.";
                exit;
            }

            $thumbnailPath = "../storage/video_thumbnails/" . basename($_FILES['thumbnail']['name']);
            if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $thumbnailPath)) {
                echo "Error: Failed to upload thumbnail image.";
                exit;
            }
        }

        $sql = "INSERT INTO videos (title, description, video_path, thumbnail_path, creator_id, visibility) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssssis", $title, $description, $videoPath, $thumbnailPath, $creator_id, $visibility);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $videoId = mysqli_insert_id($link);
            if (!empty($_POST['tags'])) {
                foreach ($_POST['tags'] as $tagId) {
                    $sql = "INSERT INTO video_tags (video_id, tag_id) VALUES (?, ?)";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ii", $videoId, $tagId);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                    }
                }
            }

            header("location: ../pages/my_account.php");
        } else {
            echo "Failed to save video data.";
        }
    } else {
        echo "Failed to upload video file.";
    }

    mysqli_close($link);
}
?>
