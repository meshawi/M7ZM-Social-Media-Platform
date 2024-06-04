function handleLike(videoId, liked) {
  fetch("../backend/handle_like.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `video_id=${videoId}&liked=${liked}`,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data.message);
      window.location.reload();
    })
    .catch((error) => console.error("Error:", error));
}

function handleFavorite(videoId, action) {
  fetch("../backend/handle_favorite.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `video_id=${videoId}&action=${action}`,
  })
    .then((response) => response.json())
    .then((data) => {
      const favoriteBtn = document.getElementById("favoriteBtn");
      const favoriteStatus = document.getElementById("favoriteStatus");
      favoriteStatus.innerText = data.message;
      if (data.success) {
        favoriteBtn.innerText =
          action === "add" ? "Remove from Favorites" : "Add to Favorites";
        favoriteBtn.onclick = () =>
          handleFavorite(videoId, action === "add" ? "remove" : "add");
      }
    })
    .catch((error) => console.error("Error:", error));
}
