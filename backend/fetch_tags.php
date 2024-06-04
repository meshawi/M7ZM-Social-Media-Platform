<?php
require 'config.php'; 

header('Content-Type: application/json');

$sql = "SELECT id, name FROM tags";
$result = mysqli_query($link, $sql);
$tags = [];

while ($row = mysqli_fetch_assoc($result)) {
    $tags[] = ['id' => $row['id'], 'name' => $row['name']];
}

echo json_encode($tags);
?>
