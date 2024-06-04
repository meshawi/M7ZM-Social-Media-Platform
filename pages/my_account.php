<?php
session_start();
require_once ("../backend/my_videos.php");
require_once '../backend/auth_check.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>My Videos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <?php require ("./navbar.php"); ?>
    <link rel="stylesheet" href="../css/my_account.css">

    <div class="container py-5">
        <div class="profile-header mb-4">
            <img src="" alt="Profile Picture" id="profileImage" class="profile-picture mb-3" />
            <h3 id="profileName">Loading...</h3>
            <p id="profileBio" class="bio">Loading...</p>
            <div class="d-flex justify-content-center text-muted mb-3">
                <div class="px-3 stat-item">
                    <strong id="videoCount">0</strong> Videos
                </div>
                <div class="px-3 stat-item">
                    <strong id="likesCount">0</strong> Likes
                </div>
                <div class="px-3 stat-item">
                    <strong id="joinedDate">Loading...</strong> Joined
                </div>
            </div>
            <div class="btn-group">
                <a href="../pages/edit_profile.php" class="btn btn-primary">Edit Profile</a>
                <a href="../pages/user_chat.php" class="btn btn-outline-secondary">Message</a>
                <a href="../pages/my_favorites.php" class="btn btn-success">My Favorites</a>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($videos as $video): ?>
                <div class="col">
                    <div class="gallery-item">
                        <img src="<?= htmlspecialchars($video['thumbnail_path']) ?>" alt="Thumbnail" class="img-fluid"
                            data-bs-toggle="modal" data-bs-target="#videoModal"
                            data-video="<?= htmlspecialchars($video['video_path']) ?>">
                        <div class="d-flex  justify-content-center">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editVideoModal"
                                data-video-id="<?= $video['id'] ?>">Edit</button>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Video Playback Modal -->
    <div class="modal fade " id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content mdl">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Video Playback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <video controls id="modalVideoPlayer">
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="card-body">
                        <h5 class="card-title" id="videoTitle"></h5>
                        <p class="card-text" id="videoDescription"></p>
                        <p class="card-text" id="videoCreatedAt"></p>
                        <p class="card-text" id="videoVisibility"></p>
                        <p class="card-text" id="videoTags"></p>
                    </div>
                    <!-- Form for deletion -->
                    <form action="../backend/delete_video.php" method="post" style="display: inline;">
                        <input type="hidden" name="id" value="<?= $video['id'] ?>">
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this video?');">Delete</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Edit Video Modal -->
    <div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content mdl">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVideoModalLabel">Edit Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editVideoForm" enctype="multipart/form-data">
                        <input type="hidden" name="videoId" id="editVideoId">
                        <div class="mb-3">
                            <label for="editTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" id="editTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editDescription" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editVisibility" class="form-label">Visibility</label>
                            <select class="form-select" id="editVisibility" name="visibility">
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                                <option value="unlisted">Unlisted</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editThumbnail" class="form-label">Thumbnail (optional)</label>
                            <input type="file" class="form-control" id="editThumbnail" name="thumbnail">
                        </div>
                        <div class="mb-3">
                            <label for="editTags" class="form-label">Tags</label>
                            <div id="editTags" class="form-check"><!-- Checkbox tags will be injected here --></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Video</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/my_videos.js"></script>

    <script>


        document.addEventListener('DOMContentLoaded', function () {
            const editForm = document.getElementById('editVideoForm');
            if (editForm) {
                editForm.addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent the default form submission
                    const formData = new FormData(this);

                    fetch('../backend/update_video.php', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            if (data.success) {
                                location.reload(); // Reload the page to reflect changes
                            }
                        })
                        .catch(error => alert('Failed to update video: ' + error));
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('[data-bs-target="#editVideoModal"]');
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const videoId = this.getAttribute('data-video-id');
                    fetch('../backend/get_video_details.php?id=' + videoId)
                        .then(response => response.json())
                        .then(data => {
                            const video = data.video;
                            document.getElementById('editVideoId').value = video.id;
                            document.getElementById('editTitle').value = video.title;
                            document.getElementById('editDescription').value = video.description;
                            document.getElementById('editVisibility').value = video.visibility;

                            // Populate tags as checkboxes
                            const tagsContainer = document.getElementById('editTags');
                            tagsContainer.innerHTML = ''; // Clear existing tags
                            data.allTags.forEach(tag => {
                                const checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.id = 'tag-' + tag.id;
                                checkbox.name = 'tags[]';
                                checkbox.value = tag.id;
                                checkbox.checked = data.tags.includes(tag.id);

                                const label = document.createElement('label');
                                label.htmlFor = 'tag-' + tag.id;
                                label.textContent = tag.name;

                                const div = document.createElement('div');
                                div.appendChild(checkbox);
                                div.appendChild(label);

                                tagsContainer.appendChild(div);
                            });
                        });
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            fetch('../backend/fetch_user_profile.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('profileName').innerText = data.data.fullname;
                        document.getElementById('profileBio').innerText = data.data.bio || 'No bio provided.';
                        document.getElementById('videoCount').innerText = data.data.video_count;
                        document.getElementById('likesCount').innerText = data.data.likes_count;
                        document.querySelector('.profile-picture').src = data.data.profile_image || 'https://via.placeholder.com/150'; // Fallback image
                    } else {
                        console.error('Failed to fetch profile data:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });
        document.addEventListener("DOMContentLoaded", function () {
            fetch("../backend/get_user_info.php")
                .then((response) => response.json())
                .then((data) => {
                    document.getElementById("profileImage").src = data.profile_image
                        ? data.profile_image
                        : "/path_to_default_image.jpg";
                })
                .catch((error) => {
                    console.log("Error fetching profile image:", error);
                    document.getElementById("profileImage").src =
                        "/path_to_default_image.jpg";
                });
        });
        document.addEventListener("DOMContentLoaded", function () {
            fetch('../backend/get_member_since.php')  // Adjust the path to the location of your PHP script
                .then(response => response.text())
                .then(dateText => {
                    document.getElementById('joinedDate').textContent = dateText; // Update the content
                })
                .catch(error => {
                    console.error('Error fetching the joined date:', error);
                    document.getElementById('joinedDate').textContent = 'N/A'; // Set default text on error
                });
        });
    </script>

</body>

</html>