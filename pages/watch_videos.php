<?php
// Start session and include config
session_start();
require_once "../backend/config.php";

require_once '../backend/auth_check.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />
    <title>Watch Videos</title>
    <!-- Bootstrap CSS from CDNJS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle JS from CDNJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php require ("./navbar.php"); ?>
    <link rel="stylesheet" href="../css/watch_videos.css">

    <div class="container mt-4">
        <h2 class="mb-3">Private Videos</h2>
        <div class="d-flex justify-content-between mb-3">
            <input type="text" class="form-control w-50 sinp" id="searchInput" placeholder="Search by title...">
            <a href="../pages/upload_video.php" class="btn btn-primary">Upload</a>
        </div>

        <!-- Tag checkboxes -->
        <div id="tagsContainer" class="mb-3">
            <!-- Tags will be added dynamically here -->
        </div>

        <!-- Sorting options -->
        <div id="sortOptions" class="mb-3">
            <label class="form-check-label pe-2">Sort by:</label>
            <div class="btn-group" role="group" aria-label="Sort options">
                <input type="radio" class="btn-check" name="sort" id="oldestSort" value="oldest" autocomplete="off">
                <label class="btn btn-outline-secondary" for="oldestSort">Oldest</label>

                <input type="radio" class="btn-check" name="sort" id="newestSort" value="newest" checked
                    autocomplete="off">
                <label class="btn btn-outline-secondary" for="newestSort">Newest</label>

                <input type="radio" class="btn-check" name="sort" id="mostViewedSort" value="mostViewed"
                    autocomplete="off">
                <label class="btn btn-outline-secondary" for="mostViewedSort">Most Viewed</label>

                <input type="radio" class="btn-check" name="sort" id="lowestViewsSort" value="lowestViews"
                    autocomplete="off">
                <label class="btn btn-outline-secondary" for="lowestViewsSort">Lowest Views</label>
            </div>
        </div>

        <div id="videosContainer" class="row">
            <!-- Videos will be loaded here dynamically -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('videosContainer');
            const tagsContainer = document.getElementById('tagsContainer');
            const searchInput = document.getElementById('searchInput');
            const oldestSortRadio = document.getElementById('oldestSort');
            const newestSortRadio = document.getElementById('newestSort');
            const mostViewedSortRadio = document.getElementById('mostViewedSort');
            const lowestViewsSortRadio = document.getElementById('lowestViewsSort');
            let allVideos = []; // Store all videos initially
            let selectedTags = []; // Store selected tags

            // Function to render videos
            function renderVideos(videos) {
                container.innerHTML = ''; // Clear container

                videos.forEach(video => {
                    const card = `
                <div class="col-md-4" card style="max-width: 340px;" onclick="window.location.href='video_details.php?id=${video.id}'">
                    <div class="card mb-3" style="cursor: pointer;">
                        <img src="${video.thumbnail_path}" class="card-img-top" alt="Video Thumbnail">
                        <div class="card-body">
                            <h5 class="card-title">${video.title}</h5>
                            <p class="card-text">${video.description}</p>
                            <div class="one-line-img">
                            <img src="${video.creator_profile_image}" class="img-fluid rounded-circle" alt="Creator Image" style="width: 30px; height: 30px;">
                            <p class="card-text"><small class="text-details creator-name"> ${video.creator_name}</small></p>

                            </div><hr>

                            <div class="one-line">
                            <p class="card-text"><small class="text-details">Duration: ${video.duration}</small></p>
                            <p class="card-text"><small class="text-details">Resolution: ${video.resolution}</small></p>
                            </div><hr>


                            <p class="card-text"><small class="text-details">Tags: ${video.tags.join(', ')}</small></p>
                            <div class="one-line">

                            <p class="card-text"><small class="text-details">Size: ${video.size}</small></p>
                            <p class="card-text"><small class="text-details">Bitrate: ${video.bitrate}</small></p>                          
                              </div><hr>

                              <div class="one-line">

                                          <p class="card-text"><small class="text-details">Created: ${video.created_at}</small></p>
                                          <p class="card-text"><small class="text-details">Views: ${video.view_count}</small></p>              
           </div>

                        </div>
                    </div>
                </div>`;
                    container.innerHTML += card;
                });
            }

            // Fetch videos and store in allVideos array
            fetch('../backend/fetch_private_public_videos.php')
                .then(response => response.json())
                .then(videos => {
                    allVideos = videos; // Store all videos
                    renderVideos(allVideos); // Render all videos initially
                    // Get unique tags from all videos
                    const allTags = Array.from(new Set(allVideos.flatMap(video => video.tags)));
                    // Render checkboxes for each tag
                    allTags.forEach(tag => {
                        const checkboxDiv = document.createElement('div');
                        checkboxDiv.classList.add('form-check-inline');
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.classList.add('form-check-input');
                        checkbox.className = 'tag-checkbox';

                        checkbox.id = tag;
                        checkbox.value = tag;
                        checkbox.addEventListener('change', function (event) {
                            if (event.target.checked) {
                                selectedTags.push(event.target.value);
                            } else {
                                selectedTags = selectedTags.filter(tag => tag !== event.target.value);
                            }
                            filterVideos();
                        });
                        const label = document.createElement('label');
                        label.className = 'btn btn-outline-primary m-1';
                        label.htmlFor = tag;
                        label.textContent = tag;
                        checkboxDiv.appendChild(checkbox);
                        checkboxDiv.appendChild(label);
                        tagsContainer.appendChild(checkboxDiv);
                    });
                })
                .catch(error => {
                    console.error('Error loading videos:', error);
                    container.innerHTML = '<p>Error loading videos.</p>';
                });

            // Function to filter videos based on selected tags and search query
            function filterVideos() {
                const searchQuery = searchInput.value.toLowerCase();
                const filteredVideos = allVideos.filter(video => {
                    const matchesSearch = video.title.toLowerCase().includes(searchQuery);
                    const matchesTags = selectedTags.length === 0 || selectedTags.every(tag => video.tags.includes(tag));
                    return matchesSearch && matchesTags;
                });
                renderVideos(filteredVideos); // Render filtered videos
            }

            // Function to sort videos by lowest views
            function sortVideos(sortBy) {
                if (sortBy === 'oldest') {
                    allVideos.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
                } else if (sortBy === 'newest') {
                    allVideos.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                } else if (sortBy === 'mostViewed') {
                    allVideos.sort((a, b) => b.view_count - a.view_count);
                } else if (sortBy === 'lowestViews') {
                    allVideos.sort((a, b) => a.view_count - b.view_count);
                }
                filterVideos(); // Reapply filters after sorting
            }

            // Add event listener to search input
            searchInput.addEventListener('input', filterVideos);

            // Add event listeners to sorting radio buttons
            oldestSortRadio.addEventListener('change', function () {
                if (this.checked) {
                    sortVideos('oldest');
                }
            });

            newestSortRadio.addEventListener('change', function () {
                if (this.checked) {
                    sortVideos('newest');
                }
            });

            mostViewedSortRadio.addEventListener('change', function () {
                if (this.checked) {
                    sortVideos('mostViewed');
                }
            });

            // Add event listener for sorting by lowest views
            lowestViewsSortRadio.addEventListener('change', function () {
                if (this.checked) {
                    sortVideos('lowestViews');
                }
            });

        });


    </script>

</body>

</html>