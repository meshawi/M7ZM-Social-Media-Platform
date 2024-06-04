<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['profile_image' => '/path_to_default_image.jpg']);
    exit;
}

$user_id = $_SESSION['id'];

$sql = "SELECT profile_image FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $profile_image);
    if (mysqli_stmt_fetch($stmt)) {
        echo json_encode(['profile_image' => $profile_image]);
    } else {
        echo json_encode(['profile_image' => '/path_to_default_image.jpg']);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['profile_image' => '/path_to_default_image.jpg']);
}

mysqli_close($link);
?>

