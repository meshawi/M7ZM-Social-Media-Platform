<?php
require_once 'config.php';

header('Content-Type: application/json');

$sql = "SELECT images.id, images.image_path, images.description, images.created_date, users.fullname, users.profile_image,
               GROUP_CONCAT(tags.name SEPARATOR ', ') AS tag_names
        FROM images
        JOIN users ON images.creator_id = users.id
        LEFT JOIN image_tags ON images.id = image_tags.image_id
        LEFT JOIN tags ON image_tags.tag_id = tags.id
        GROUP BY images.id";

$result = mysqli_query($link, $sql);
$images = [];

while ($row = mysqli_fetch_assoc($result)) {
    $images[] = [
        'id' => $row['id'],
        'imagePath' => $row['image_path'],
        'description' => $row['description'],
        'fullname' => $row['fullname'],
        'profileImage' => $row['profile_image'],
        'tags' => explode(', ', $row['tag_names']),
        'created_date' => $row['created_date']
    ];
}

mysqli_free_result($result);
mysqli_close($link);

echo json_encode($images);
?>
