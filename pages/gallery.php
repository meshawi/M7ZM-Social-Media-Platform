<?php session_start();

require_once '../backend/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>Image Gallery</title>
    <!-- Bootstrap CSS from CDNJS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle JS from CDNJS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>

<body><?php
require ("./navbar.php")
    ?>
    <div class="container mt-4">
        <link rel="stylesheet" href="../css/gallery.css">

        <h2>Image Gallery</h2>

        <div id="filters" class="mb-3">
            <div class="d-flex justify-content-between mb-3">

                <input type="text" id="searchInput" class="form-control w-50" placeholder="Search by description...">
                <a href="./upload_image.php" class="btn btn-primary">Upload</a>
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
                </div>
            </div>
        </div>
        <div class="row" id="gallery"></div>
    </div>


    <!-- Modal Structure -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="" id="modalImage" class="img-fluid mb-3" alt="...">
                    <p id="modalDescription"></p>
                    <div class="one-line-img">
                        <img src="" id="modalCreatorImage" class="img-thumbnail" width="50" alt="Creator">

                        <p><span class="creator-name" id="modalCreator"></span></p>
                    </div>
                    <hr>

                    <p><strong>Created on:</strong> <span id="modalCreateDate"></span></p> <!-- Display create date -->
                    <div><strong>Tags:</strong> <span id="modalTags"></span></div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Fetch API to load images -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gallery = document.getElementById('gallery');
            const tagsContainer = document.getElementById('tagsContainer');
            const searchInput = document.getElementById('searchInput');
            const oldestSortRadio = document.getElementById('oldestSort');
            const newestSortRadio = document.getElementById('newestSort');
            let allImages = [];
            let selectedTags = [];

            // Fetch tags and append them to the tag container
            fetch('../backend/fetch_tags.php')
                .then(response => response.json())
                .then(tags => {
                    tags.forEach(tag => {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = 'tag-' + tag.id;  // Ensuring unique IDs
                        checkbox.value = tag.name;
                        checkbox.className = 'tag-checkbox';
                        checkbox.addEventListener('change', filterImages);

                        const label = document.createElement('label');
                        label.htmlFor = 'tag-' + tag.id;
                        label.textContent = tag.name;
                        label.className = 'btn btn-outline-primary m-1';

                        tagsContainer.appendChild(checkbox);
                        tagsContainer.appendChild(label);
                    });
                });

            // Fetch images and render them in the gallery
            fetch('../backend/fetch_images.php')
                .then(response => response.json())
                .then(images => {
                    allImages = images;
                    renderImages(images);
                });

            // Filter images based on selected tags and search query
            function filterImages() {
                const searchQuery = searchInput.value.toLowerCase();
                selectedTags = Array.from(document.querySelectorAll('.tag-checkbox:checked')).map(input => input.value);
                const filteredImages = allImages.filter(image => {
                    const matchesSearch = image.description.toLowerCase().includes(searchQuery);
                    const matchesTags = selectedTags.length === 0 || selectedTags.every(tag => image.tags.includes(tag));
                    return matchesSearch && matchesTags;
                });
                renderImages(filteredImages);
            }

            // Sort images by creation date
            function sortImages(sortBy) {
                if (sortBy === 'oldest') {
                    allImages.sort((a, b) => new Date(a.created_date) - new Date(b.created_date));
                } else if (sortBy === 'newest') {
                    allImages.sort((a, b) => new Date(b.created_date) - new Date(a.created_date));
                }
                filterImages(); // Reapply filters after sorting
            }

            // Render images in the gallery
            function renderImages(images) {
                gallery.innerHTML = '';  // Clear previous content
                images.forEach(img => {
                    const imgElement = document.createElement('img');
                    imgElement.src = img.imagePath;
                    imgElement.className = 'gallery-image';
                    imgElement.alt = 'Image';
                    imgElement.addEventListener('click', () => showModal(img));

                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-4';
                    col.appendChild(imgElement);
                    gallery.appendChild(col);
                });
            }

            // Display modal with image and its details
            function showModal(img) {
                document.getElementById('modalImage').src = img.imagePath;
                document.getElementById('modalDescription').textContent = img.description;
                document.getElementById('modalCreator').textContent = img.fullname;
                document.getElementById('modalCreatorImage').src = img.profileImage;
                document.getElementById('modalTags').textContent = img.tags.join(', ');
                document.getElementById('modalCreateDate').textContent = new Date(img.created_date).toLocaleDateString(); // Format date
                new bootstrap.Modal(document.getElementById('imageModal')).show();
            }

            // Event listeners for sorting options
            oldestSortRadio.addEventListener('change', () => {
                if (oldestSortRadio.checked) {
                    sortImages('oldest');
                }
            });

            newestSortRadio.addEventListener('change', () => {
                if (newestSortRadio.checked) {
                    sortImages('newest');
                }
            });

            // Event listener for search input
            searchInput.addEventListener('input', filterImages);
        });

    </script>
</body>

</html>