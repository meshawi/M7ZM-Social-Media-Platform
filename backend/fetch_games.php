<?php
include 'config.php';

header('Content-Type: application/json');

$sql = "SELECT g.*, AVG(r.rating) AS average_rating, COUNT(r.id) AS review_count 
        FROM games2rate g
        LEFT JOIN reviews r ON g.id = r.game_id
        GROUP BY g.id";

$result = $link->query($sql);
$games = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $games[] = $row;
    }
    echo json_encode($games);
} else {
    echo json_encode([]);
}
$link->close();
?>
