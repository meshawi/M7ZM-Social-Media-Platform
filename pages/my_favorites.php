<?php
session_start();
require_once '../backend/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>My Favorite Videos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body> <?php
require ("./navbar.php")
    ?>
    <link rel="stylesheet" href="../css/my_favorites.css">

    <div class="container mt-4">
        <h2>My Favorite Videos</h2>
        <div id="videosContainer" class="row">
            <!-- Videos will be loaded here dynamically -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('../backend/fetch_favorites.php')
                .then(response => response.json())
                .then(videos => {
                    const container = document.getElementById('videosContainer');
                    videos.forEach(video => {
                        const card = `
                <div class="col-md-4" style="max-width: 340px;">
                    <div class="card mb-3" style="cursor: pointer;" onclick="window.location.href='video_details.php?id=${video.id}'">
                        <img src="${video.thumbnail_path}" class="card-img-top" alt="Video Thumbnail">
                        <div class="card-body">
                            <h5 class="card-title">${video.title}</h5>
                            <p class="card-text">${video.description}</p>
                            <p class="card-text"><small class="text-c"> on ${new Date(video.created_at).toLocaleDateString()}</small></p>
                            <div class="one-line-img">
                            <img src="${video.creator_profile_image}" class="img-fluid rounded-circle" alt="Creator Image" style="width: 30px; height: 30px;">
                            <p class="card-text"><small class="creator-name"> ${video.creator_name}</small></p>
                            </div>
                            </div>
                    </div>
                </div>`;
                        container.innerHTML += card;
                    });
                })
                .catch(error => {
                    console.error('Error loading videos:', error);
                    document.getElementById('videosContainer').innerHTML = '<p>Error loading videos.</p>';
                });
        });
    </script>


</body>

</html>