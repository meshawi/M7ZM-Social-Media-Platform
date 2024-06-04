<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
        $user_id = $_SESSION['id'];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    $game_id = $_POST['game_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $link->prepare("INSERT INTO reviews (game_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $game_id, $user_id, $rating, $comment);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to insert review"]);
    }
    $stmt->close();
    $link->close();
}
