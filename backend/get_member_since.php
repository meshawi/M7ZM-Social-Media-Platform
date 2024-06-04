<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['id'])) {
    echo "N/A";
    exit;
}

$user_id = $_SESSION['id'];
$sql = "SELECT created_at FROM users WHERE id = ?";

if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $created_at);
    if (mysqli_stmt_fetch($stmt)) {
        echo date('F j, Y', strtotime($created_at));
    } else {
        echo "N/A";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "N/A";
}
mysqli_close($link);
?>
