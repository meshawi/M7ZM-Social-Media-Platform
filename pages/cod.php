<?php
session_start();
require_once '../backend/auth_check.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

  <title>Call of Duty Timeline</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

</head>

<body> <?php
require ("./navbar.php")
  ?>
  <link rel="stylesheet" href="../css/cod.css">

  <div class="container my-5">
    <h1 class="mb-4">Call of Duty Release Timeline</h1>
    <input type="text" class="form-control search-bar" id="searchInput" placeholder="Search by game name..." />
    <div class="filter-buttons">
      <button class="btn filter-button" onclick="filterGames('all')">
        All
      </button>
      <button class="btn filter-button" onclick="filterGames('2020s')">
        2020s
      </button>
      <button class="btn filter-button" onclick="filterGames('2010s')">
        2010s
      </button>
      <button class="btn filter-button" onclick="filterGames('2000s')">
        2000s
      </button>
    </div>
    <div id="gamesContainer" class="row"></div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function getTimeSince(date) {
      const now = new Date();
      const then = new Date(date);
      const months =
        (now.getFullYear() - then.getFullYear()) * 12 +
        now.getMonth() -
        then.getMonth();
      const years = Math.floor(months / 12);
      let remainderMonths = months % 12;
      let days = now.getDate() - then.getDate();
      if (days < 0) {
        remainderMonths--;
        days += new Date(now.getFullYear(), now.getMonth(), 0).getDate();
      }
      return `${years} years, ${remainderMonths} months, ${days} days`;
    }

    function filterGames(decade) {
      const allCards = document.querySelectorAll(".game-card");
      const searchText = document
        .getElementById("searchInput")
        .value.toLowerCase();
      allCards.forEach((card) => {
        const name = card.getAttribute("data-name").toLowerCase();
        const cardDecade = card.getAttribute("data-decade");
        if (
          (decade === "all" || cardDecade === decade) &&
          name.includes(searchText)
        ) {
          card.style.display = "";
        } else {
          card.style.display = "none";
        }
      });
    }

    document
      .getElementById("searchInput")
      .addEventListener("input", () => filterGames("all"));

    document.addEventListener("DOMContentLoaded", function () {
      fetch("../assets/cod.json") // Ensure this URL is correct based on your server setup
        .then((response) => response.json())
        .then((data) => {
          const container = document.getElementById("gamesContainer");
          data.forEach((game) => {
            const timeSinceRelease = getTimeSince(game.releaseDate);
            const releaseYear = new Date(game.releaseDate).getFullYear();
            const decade = `${Math.floor(releaseYear / 10) * 10}s`;
            const cardHtml = `
                        <div class="col-md-4 mb-4 game-card" data-name="${game.name}" data-decade="${decade}">
                            <div class="card">
                                <img src="${game.image}" class="card-img-top" alt="${game.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${game.name}</h5>
                                    <p class="card-text">It's been ${timeSinceRelease} since the release.</p>
                                    <div class="tooltip">Release Year: ${releaseYear}</div>
                                </div>
                            </div>
                        </div>`;
            container.innerHTML += cardHtml;
          });
        });
    });
  </script>
</body>

</html>