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

    <title>Game Reviews</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body><?php
require ("./navbar.php")
    ?>
    <link rel="stylesheet" href="../css/games.css">

    <div class="container py-5">
        <h1 class="mb-4 pagetitle">Game Reviews</h1>
        <div id="gamesContainer"></div>
    </div>

    <!-- Modals for Reviews -->
    <!-- Submit Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Submit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm">
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating (1-10)</label>
                            <input type="range" class="form-range" min="1" max="10" value="1" id="rating" name="rating"
                                onchange="updateRatingValue(this.value);">
                            <span id="ratingValue">1</span>/10
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <input type="hidden" name="game_id" id="gameId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="submitReview()">Submit Review</button>
                </div>
            </div>
        </div>
    </div>
    <!-- View Reviews Modal -->
    <div class="modal fade" id="viewReviewsModal" tabindex="-1" aria-labelledby="viewReviewsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewReviewsModalLabel">Game Reviews</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="reviewsContainer"></div>
            </div>
        </div>
    </div>

    <script>// This function updates the display of the rating value when the slider changes
        function updateRatingValue(value) {
            $('#ratingValue').text(value); // Update the text display of the rating
        }
        $(document).ready(function () {
            // Function to update the rating value display
            function updateRatingValue(value) {
                $('#ratingValue').text(value);
            }

            // Function to fetch games and render them
            function fetchGames() {
                $.ajax({
                    url: '../backend/fetch_games.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function (games) {
                        var html = '';
                        games.forEach(function (game) {
                            html += `
                        <div class="card mb-3">
                            <img src="${game.image_url}" class="card-img-top" alt="${game.name}">
                            <div class="card-body">
                                <h5 class="card-title">${game.name}</h5>
                                <p class="card-text"><strong>Release Date:</strong> ${new Date(game.release_date).toLocaleDateString()}</p>
                                <p class="card-text">Average Rating: ${game.average_rating ? `${parseFloat(game.average_rating).toFixed(1)} (${game.review_count} reviews)` : 'No reviews yet'}</p>
                                <button onclick="promptReview(${game.id})" class="btn btn-primary">Rate This Game</button>
                                <button onclick="viewReviews(${game.id})" class="btn btn-secondary">View Reviews</button>
                            </div>
                        </div>`;
                        });
                        $('#gamesContainer').html(html);
                    },
                    error: function (error) {
                        console.error('Error fetching games:', error);
                    }
                });
            }

            // Function to show the review modal
            window.promptReview = function (gameId) {
                $('#gameId').val(gameId);
                $('#reviewModal').modal('show');
            };

            window.submitReview = function () {
                var formData = $('#reviewForm').serialize();
                $.ajax({
                    type: 'POST',
                    url: '../backend/submit_review.php',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 'success') {
                            alert('Review submitted!');
                            $('#reviewModal').modal('hide');
                            fetchGames();
                        } else {
                            alert('Failed to submit review: ' + data.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Failed to submit review:', status, error, xhr.responseText);
                    }
                });
            };


            fetchGames();
        }); window.viewReviews = function (gameId) {
            $.ajax({
                url: '../backend/fetch_reviews.php',
                type: 'GET',
                data: { game_id: gameId },
                dataType: 'json',
                success: function (reviews) {
                    var html = '';
                    reviews.forEach(function (review) {
                        html += `
                <div class="review-card mb-3">
                    <div class="media">
                        <img src="${review.profile_image}" class="mr-3" alt="User Image" style="width: 64px; height: 64px; border-radius: 50%;">
                        <div class="media-body">
                            <h5 class="mt-0">${review.fullname} (@${review.username})</h5>
                            <p>Rating: ${review.rating} / 10</p>
                            <p>commen: ${review.comment}</p>
                            <hr>
                        </div>
                    </div>
                </div>`;
                    });
                    $('#reviewsContainer').html(html);
                    $('#viewReviewsModal').modal('show');
                },
                error: function () {
                    alert('Failed to fetch reviews.');
                }
            });
        };

    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>