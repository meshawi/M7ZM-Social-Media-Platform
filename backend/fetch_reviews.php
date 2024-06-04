<?php
session_start();
include 'config.php';
header('Content-Type: application/json');

if (isset($_GET['game_id'])) {
    $game_id = $_GET['game_id'];

    $query = "SELECT r.rating, r.comment, u.username, u.fullname, u.profile_image 
              FROM reviews r
              JOIN users u ON r.user_id = u.id
              WHERE r.game_id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    echo json_encode($reviews);
    $stmt->close();
} else {
    echo json_encode(['error' => 'Game ID not specified']);
}

$link->close();
?>