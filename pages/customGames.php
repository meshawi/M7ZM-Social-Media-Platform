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

    <title>Overwatch Custom Maps</title>
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require ("./navbar.php"); ?>
    <link rel="stylesheet" href="../css/customGames.css">

    <body>
        <div class="container mt-4">
            <h2 class="ptitl">Game Gallery</h2>
            <p class="pdesc">Get a custom Overwatch code map</p>
            <div class="d-flex justify-content-between mb-3">

                <input type="text" id="searchInput" class="form-control w-50" placeholder="Search games...">
            </div>

            <div id="tagsContainer" class="mb-3"></div>
            <div id="customGamesContainer"></div>
        </div>

        <!-- Additional script and elements remain unchanged -->
    </body>




    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('customGamesContainer');
            const searchInput = document.getElementById('searchInput');
            const tagsContainer = document.getElementById('tagsContainer');
            let allGames = [];
            let selectedTags = [];

            // Fetch tags and create checkboxes
            fetch('../backend/fetch_ow_tags.php')
                .then(response => response.json())
                .then(tags => {
                    tags.forEach(tag => {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = 'tag-' + tag;
                        checkbox.value = tag;
                        checkbox.className = 'btn-check';  // Bootstrap’s btn-check class for toggle behavior
                        checkbox.autocomplete = "off"; // Disable autocomplete to avoid browser caching input state

                        const label = document.createElement('label');
                        label.htmlFor = 'tag-' + tag;
                        label.textContent = tag;
                        label.className = 'btn btn-outline-primary m-1'; // Styling

                        const div = document.createElement('div');
                        div.className = 'form-check-inline';
                        div.appendChild(checkbox);
                        div.appendChild(label);
                        tagsContainer.appendChild(div);

                        checkbox.addEventListener('change', () => {
                            selectedTags = Array.from(tagsContainer.querySelectorAll('.btn-check:checked')).map(el => el.value);
                            filterGames();
                        });
                    });
                });

            // Fetch games and render
            fetch('../backend/fetch_custom_games.php')
                .then(response => response.json())
                .then(games => {
                    allGames = games;
                    filterGames(); // Initial render
                });

            // Filter and render games
            function filterGames() {
                const searchText = searchInput.value.toLowerCase();
                const filteredGames = allGames.filter(game => {
                    const matchesTags = selectedTags.length === 0 || game.tags.some(tag => selectedTags.includes(tag));
                    const matchesText = game.title.toLowerCase().includes(searchText) || game.description.toLowerCase().includes(searchText);
                    return matchesTags && matchesText;
                });
                renderGames(filteredGames);
            }

            function renderGames(games) {
                container.innerHTML = '';
                games.forEach((game, index) => {
                    const article = document.createElement('div');
                    article.className = `card-container`;
                    article.innerHTML = `
                <a class="hero-image-container" href="#" onclick="copyCode('${game.code}')">
                    <img class="hero-image" src="${game.thumbnail}" alt="${game.title}" />
                </a>
                <main class="main-content">
                    <h1><a href="#">${game.title}</a></h1>
                    <p>${game.description}</p>
                    <div class="tag-container">
                        ${game.tags.map(tag => `<span class="badge bg-success">${tag}</span>`).join(' ')}
                    </div>
                    <div class="flex-row">
                        <div class="time-left">
                            <p class="mt-2">${new Date(game.date_of_upload).toLocaleDateString()}</p>
                        </div>
                    </div>
                </main>
                <div class="card-attribute">
                    <button class="btn btn-warning" onclick="copyCode('${game.code}')"><i class="fas fa-copy mr-2"></i>Copy Code</button>
                </div>
            `;
                    container.appendChild(article);
                });
            }

            // Copy game code to clipboard
            window.copyCode = function (code) {
                navigator.clipboard.writeText(code).then(() => {
                    alert('Code copied to clipboard!');
                }).catch(err => {
                    console.error('Failed to copy:', err);
                });
            }

            // Event listener for search input
            searchInput.addEventListener('input', filterGames);
        });

    </script>
</body>

</html>