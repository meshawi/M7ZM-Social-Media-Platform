<?php
require_once 'config.php';

$status = $_POST['status'];  // 'online' or 'offline'
$user_id = $_POST['user_id'];

$sql = "UPDATE users SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $user_id);
$stmt->execute();
