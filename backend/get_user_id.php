<?php
require_once "config.php";
session_start();

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $sql = "SELECT id FROM users WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id);
        
        if (mysqli_stmt_fetch($stmt)) {
            echo json_encode(['success' => true, 'user_id' => $user_id]);
        } else {
            echo json_encode(['success' => false]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false]);
    }

    mysqli_close($link);
} else {
    echo json_encode(['success' => false]);
}
?>
