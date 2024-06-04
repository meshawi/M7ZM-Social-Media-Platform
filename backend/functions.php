<?php
require_once 'config.php';

function fetchTags() {
    global $link; 
    $tags = [];
    $sql = "SELECT id, name FROM tags";
    if ($result = mysqli_query($link, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $tags[] = $row;
        }
        mysqli_free_result($result);
    }
    return $tags;
}
?>
