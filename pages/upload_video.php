<?php
session_start();
require_once '../backend/auth_check.php';
include '../backend/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>Upload Video</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php require ("./navbar.php") ?>
    <link rel="stylesheet" href="../css/upload_video.css">

    <div class="container mt-4">
        <h2 class="mb-4">Upload Video</h2>
        <form action="../backend/upload_video.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="video" class="form-label">Video File:</label>
                    <input type="file" class="form-control" id="video" name="video" required>
                </div>
                <div class="col-md-6">
                    <label for="thumbnail" class="form-label">Thumbnail Image (Optional):</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                </div>
            </div>
            <div class="mb-3">
                <label for="visibility" class="form-label">Visibility:</label>
                <select class="form-select" id="visibility" name="visibility">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                    <option value="unlisted">Unlisted</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tags:</label>
                <div class="row">
                    <?php
                    $tags = fetchTags();
                    foreach ($tags as $tag) {
                        echo '<div class="col-md-3 col-sm-6">';
                        echo '<input class="tag-checkbox" type="checkbox" name="tags[]" id="tag' . $tag['id'] . '" value="' . $tag['id'] . '">';
                        echo '<label class="btn btn-outline-primary mb-2" for="tag' . $tag['id'] . '">' . htmlspecialchars($tag['name']) . '</label>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-cloud-upload-alt"></i> Upload Video</button>
        </form>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('video').addEventListener('change', function (event) {
            const thumbnailInput = document.getElementById('thumbnail');
            thumbnailInput.value = '';

            const file = event.target.files[0];
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);

            video.addEventListener('loadeddata', function () {
                this.currentTime = Math.min(5, this.duration / 2); // Adjust time logic as needed
            });

            video.addEventListener('seeked', function () {
                const canvas = document.createElement('canvas');
                canvas.width = this.videoWidth;
                canvas.height = this.videoHeight;
                canvas.getContext('2d').drawImage(this, 0, 0, canvas.width, canvas.height);

                canvas.toBlob(function (blob) {
                    // Use the current timestamp to create a unique filename for each thumbnail
                    const timestamp = Date.now();
                    const uniqueFilename = 'thumbnail_' + timestamp + '.jpg';

                    const newFile = new File([blob], uniqueFilename, {
                        type: 'image/jpeg',
                        lastModified: timestamp
                    });

                    // Update the thumbnail file input with the new unique file
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(newFile);
                    thumbnailInput.files = dataTransfer.files;

                    // Trigger change event for any other scripts that need to know about this update
                    thumbnailInput.dispatchEvent(new Event('change'));
                }, 'image/jpeg');
            });
        });
    </script>

    <!-- Link Font Awesome for icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>

</html>