<?php
header('Content-Type: application/json');
require_once 'config.php';

try {
    $sql = "SELECT tag_name FROM owtags ORDER BY tag_name";
    $result = mysqli_query($link, $sql);

    $tags = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tags[] = $row['tag_name'];
        }
        echo json_encode($tags);
    } else {
        throw new Exception("Database query failed.");
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    mysqli_close($link);
}
?>
