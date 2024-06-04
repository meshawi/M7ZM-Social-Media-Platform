<?php
require_once "config.php";
session_start();

if (isset($_GET['title'])) {
    $title = htmlspecialchars($_GET['title']);

    $stmt = $pdo->prepare("SELECT * FROM videos WHERE title LIKE ?");
    $stmt->execute(["%$title%"]);
    
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['videos' => $videos]);
} else {
    echo json_encode(['videos' => []]);
}
?>
