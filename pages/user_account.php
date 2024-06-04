<?php
session_start();
require_once ("../backend/user_account.php");
require_once '../backend/auth_check.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

  <title>User Account</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Add your custom CSS if needed -->

</head>

<body>
  <?php
  require ("./navbar.php")
    ?>
  <link rel="stylesheet" href="../css/user_account.css">

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-4 offset-md-4">
        <div class="profile-header">
          <img src="<?= htmlspecialchars($userData['profile_image']) ?>" alt="Profile Picture"
            class="profile-picture" />
          <div class="profile-name"><?= htmlspecialchars($userData['fullname']) ?></div>
          <div class="profile-bio"><?= htmlspecialchars($userData['bio']) ?></div>
          <div class="profile-stats">
            <div class="stat-item">
              <span>Videos</span>
              <strong><?= $userData['video_count'] ?></strong>
            </div>
            <div class="stat-item">
              <span>Likes</span>
              <strong><?= $userData['likes_count'] ?></strong>
            </div>
          </div>
          <div class="profile-actions">
            <a href="../pages/user_chat.php" class="btn btn-primary">Message</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-8 offset-md-2">
      <div class="gallery">
        <!-- Display user's videos if available -->
        <?php foreach ($videos as $video): ?>
          <div class="gallery-item">
            <img src="<?= htmlspecialchars($video['thumbnail_path']) ?>" class="card-img-top" alt="Thumbnail"
              data-bs-toggle="modal" data-bs-target="#videoModal<?= $video['id'] ?>">
          </div>

          <!-- Modal for video playback -->
          <div class="modal fade" id="videoModal<?= $video['id'] ?>" tabindex="-1"
            aria-labelledby="videoModalLabel<?= $video['id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="videoModalLabel<?= $video['id'] ?>">Video Playback</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <!-- Video element where the video will be loaded dynamically -->
                  <video controls id="modalVideoPlayer" style="width: 100%;">
                    <source src="<?= htmlspecialchars($video['video_path']) ?>" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                  <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($video['title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($video['description']) ?></p>
                    <p class="card-text"><strong>Tags: </strong><?= htmlspecialchars($video['tags']) ?></p>
                    <p class="card-text"><strong>Views: </strong><?= $video['view_count'] ?></p>
                    <!-- Display other video details as needed -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  </div>

  <!-- Footer section if needed -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Add your custom JavaScript if needed -->
  <script>
    // Your custom JavaScript code here
  </script>
</body>

</html>