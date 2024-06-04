<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $creator_id = $_SESSION['id'];
    $imagePath = "../storage/images/" . basename($_FILES['image']['name']);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
        $sql = "INSERT INTO images (description, image_path, creator_id, created_date) VALUES (?, ?, ?, NOW())";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssi", $description, $imagePath, $creator_id);
            mysqli_stmt_execute($stmt);
            $imageId = mysqli_insert_id($link);
            mysqli_stmt_close($stmt);

            if (!empty($_POST['tags'])) {
                foreach ($_POST['tags'] as $tagId) {
                    $sql = "INSERT INTO image_tags (image_id, tag_id) VALUES (?, ?)";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ii", $imageId, $tagId);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);
                    }
                }
            }
            header("Location: ../pages/gallery.php"); 
        } else {
            echo "Failed to save image data.";
        }
    } else {
        echo "Failed to upload image file.";
    }
    mysqli_close($link);
}
?>
