<?php
header('Content-Type: application/json');
require_once 'config.php';

$sql = "SELECT oc.id, oc.title, oc.description, oc.code, oc.thumbnail, oc.date_of_upload,
        GROUP_CONCAT(ot.tag_name SEPARATOR ', ') AS tags
        FROM ow_custom oc
        LEFT JOIN ow_custom_tags oct ON oc.id = oct.custom_id
        LEFT JOIN owtags ot ON oct.tag_id = ot.tag_id
        GROUP BY oc.id";

$result = mysqli_query($link, $sql);

$games = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $games[] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'description' => $row['description'],
            'code' => $row['code'],
            'thumbnail' => $row['thumbnail'],
            'date_of_upload' => $row['date_of_upload'],
            'tags' => explode(', ', $row['tags'])
        ];
    }
    echo json_encode($games);
} else {
    echo json_encode(['error' => mysqli_error($link)]);
}

mysqli_close($link);
?>
