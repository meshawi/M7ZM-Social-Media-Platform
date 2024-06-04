<?php session_start();

require_once "../backend/config.php";
require_once '../backend/auth_check.php';

require_once "../backend/video_details.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>Video Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <?php require ("./navbar.php") ?>
    <link rel="stylesheet" href="../css/video_details.css">

    <div class="container mt-4">
        <h1 class="mb-3 vtitle"><?= htmlspecialchars($video['title']) ?></h1>
        <div class="video-wrapper">
            <video class="responsive-video" controls src="<?= htmlspecialchars($video['video_path']) ?>"
                poster="<?= htmlspecialchars($video['thumbnail_path']) ?>"></video>
        </div>
        <p class="mt-3"><?= htmlspecialchars($video['description']) ?></p>
        <div class="d-flex align-items-center mt-3">
            <img id="creatorProfileImage" src="<?= htmlspecialchars($video['creator_profile_image']) ?>"
                class="creator-profile me-2" alt="Creator Image">
            <p class="mb-0 cn"><span class="profile-link"
                    onclick="window.location.href='user_account.php?user_id=<?= $video['creator_id'] ?>'"><?= htmlspecialchars($video['creator_name']) ?></span>
                on <?= date('F j, Y', strtotime($video['created_at'])) ?></p>
        </div>
        <div class="video-controls my-3 lkscontainer">
            <button class="btn btn-outline-success" onclick="handleLike(<?= $video['id'] ?>, true)">
                <i class="bi bi-hand-thumbs-up-fill"></i> Like
            </button>
            <span id="likeCount"><?= $video['like_count'] ?: 0 ?></span>

            <button class="btn btn-outline-danger" onclick="handleLike(<?= $video['id'] ?>, false)">
                <i class="bi bi-hand-thumbs-down-fill"></i> Dislike
            </button>
            <span id="dislikeCount"><?= $video['dislike_count'] ?: 0 ?></span>

            <button id="favoriteBtn" class="btn btn-outline-info"
                onclick="handleFavorite(<?= $video['id'] ?>, '<?= $isFavorite ? 'remove' : 'add' ?>')">
                <i class="bi <?= $isFavorite ? 'bi-star-fill' : 'bi-star' ?>"></i>
                <?= $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' ?> <span id="favoriteStatus"></span>

            </button>
        </div>

        <div class="comment-box">
            <h3>Comments</h3>
            <?php foreach ($comments as $comment): ?>
                <div class="comment py-2 px-3 my-2 rounded">
                    <strong><?= htmlspecialchars($comment['username']) ?></strong> at
                    <em><?= date('F j, Y, g:i a', strtotime($comment['created_at'])) ?></em>
                    <p><?= htmlspecialchars($comment['comment']) ?></p>
                </div>
            <?php endforeach; ?>

            <h4>Add a comment</h4>
            <form action="" method="POST">
                <textarea class="form-control  addcomnt mb-2" name="comment" required></textarea>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>


    </div>
    <script src="../js/video_details.js"></script>
</body>

</html>