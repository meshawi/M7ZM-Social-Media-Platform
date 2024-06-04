<?php
session_start();
require_once ("../backend/config.php");
require_once '../backend/auth_check.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>M7zm - Your Gaming Social Network</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.7.4/lottie.min.js"></script>
    <link rel="stylesheet" href="../css/GlobalStyles.css">
    <link rel="stylesheet" href="../css/home.css">
    <style>
        #mainNavbar,
        .dropdown-menu {
            background-color: rgba(0, 0, 0, 0.85) !important;
            /* Semi-transparent black background */
        }

        .navbar-brand,
        .nav-link,
        .dropdown-item {
            color: white !important;
            /* White text for better visibility */
        }

        .nav-link:hover,
        .dropdown-item:hover,
        .nav-item.active .nav-link {
            color: #f0b90b !important;
            /* Highlight elements on hover with a gold color */
        }

        .navbar-toggler {
            border-color: #f0b90b !important;
            /* Gold border color for the toggle button */
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='%23f0b90b' stroke-width='2' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .navbar-nav {
            width: 100%;
            justify-content: center;
            /* Center navigation links */
        }

        .nav-item {
            margin: 0 15px;
            /* Spacing between nav items */
        }

        .dropdown {
            position: absolute;
            right: 10px;
            /* Position the profile image to the right */
        }

        .profile-image {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            /* Make the image round */
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="../index.html">M7zm</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#hero">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./watch_videos.php">Clips</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./gallery.php">Stats</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./cod.php">Cod</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./games.php">Games Rate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./customGames.php">OW Custom</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./trjmh.php">TRJMH</a>
                    </li>
                </ul>

                <div class="dropdown">
                    <img src="" alt="User Profile" class="profile-image dropdown-toggle profile-picture"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="./my_account.php">View My Account</a>
                        <a class="dropdown-item" href="./edit_profile.php">Edit Profile</a>
                        <a class="dropdown-item" href="./search_user.php">Search for users</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../backend/logout.php">Sign Out</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="hero">
        <div class="hero-content">
            <h1>Welcome <span id="profileName"></span> to M7zm</h1>
            <p>Connect, Share, and Explore Your Gaming World</p>
            <a href="#features" class="btn btn-main">Discover More</a>
        </div>
        <div class="hero-background"></div>
    </div>
    <div id="features">
        <div class="animation-container">
            <div id="lottie-animation"></div>
        </div>
        <div class="feature-row">
            <div class="feature-tile" style="background-image: url('../assets/images/1.jpg');">
                <!-- <img src="../assets/codeImages/a.jpg" alt="Games"> -->
                <h3>Watch Clips</h3>
                <!-- <p>Explore and watch the boy's clips.</p> -->
                <div class="overlay">
                    <div class="overlay-content">
                        <p>Discover latest game clips</p>
                        <a href="./watch_videos.php">Watch Now</a>
                    </div>
                </div>
            </div>
            <div class="feature-tile" style="background-image: url('../assets/images/2.jpg');">
                <h3>Stats</h3>
                <!-- <p>View and share the best Stats.</p> -->
                <div class="overlay">
                    <div class="overlay-content">
                        <p>Explore the boy's Stats</p>
                        <a href="./gallery.php">View Now</a>
                    </div>
                </div>
            </div>
            <div class="feature-tile" style="background-image: url('../assets/images/3.jpg');">
                <h3>Reviews</h3>
                <!-- <p>Rate and write and see reviews on games.</p> -->
                <div class="overlay">
                    <div class="overlay-content">
                        <p>Rate and review games</p>
                        <a href="./games.php">Rate Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature-row">

            <div class="feature-tile" style="background-image: url('../assets/images/4.jpg');">
                <h3>OW maps</h3>
                <!-- <p>Get the best OverWatch custom maps code</p> -->
                <div class="overlay">
                    <div class="overlay-content">
                        <p>Watch the maps-Get the codes</p>
                        <a href="./games.php">Get code</a>
                    </div>
                </div>
            </div>
            <div class="feature-tile" style="background-image: url('../assets/images/5.jpg');">
                <h3>Cod Relase</h3>
                <!-- <p>See how long is it been since game relace</p> -->
                <div class="overlay">
                    <div class="overlay-content">
                        <p>All Call of duty Games</p>
                        <a href="./games.php">View Now</a>
                    </div>
                </div>
            </div>
            <div class="feature-tile" style="background-image: url('../assets/images/9.jpg');">
                <h3>T3reb Words</h3>
                <!-- <p>use this tool to transolate T3reb to Arabic</p> -->
                <div class="overlay">
                    <div class="overlay-content">
                        <p>3rb ay klmh aw trjm</p>
                        <a href="./games.php">View Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="feature-row">
            <div class="chat">
                <!-- <img src="../assets/codeImages/a.jpg" alt="Games"> -->
                <a href="./user_chat.php" class="btn btn-success">Start Chat</a>

                <div class="animation-container2">
                    <div id="lottie-animation2"></div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/home.js"></script>
    <script>
        $(document).ready(function () {
            var previousScroll = 0;
            $(window).scroll(function () {
                var currentScroll = $(this).scrollTop();
                if (currentScroll > 0) {
                    $('#mainNavbar').css('top', '0'); // Navbar shows when not at the top
                } else {
                    $('#mainNavbar').css('top', '-100px'); // Navbar hides when at the top
                }
                previousScroll = currentScroll;
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            fetch('../backend/fetch_user_profile.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('profileName').innerText = data.data.fullname;
                        document.querySelector('.profile-picture').src = data.data.profile_image || 'https://via.placeholder.com/150'; // Fallback image
                    } else {
                        console.error('Failed to fetch profile data:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });
    </script>

</body>

</html>