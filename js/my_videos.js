document.addEventListener("click", function (e) {
  if (e.target.dataset.video) {
    const videoPlayer = document.getElementById("modalVideoPlayer");
    videoPlayer.src = e.target.dataset.video;
    videoPlayer.load();
  }
});

$("#videoModal").on("hidden.bs.modal", function () {
  const videoPlayer = document.getElementById("modalVideoPlayer");
  videoPlayer.pause();
  videoPlayer.src = "";
});

document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".delete-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const videoId = this.getAttribute("data-video-id");
      if (confirm("Are you sure you want to delete this video?")) {
        fetch("../backend/delete_video.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "id=" + encodeURIComponent(videoId),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              window.location.reload();
            } else {
              alert("Error deleting video: " + data.message);
            }
          })
          .catch((error) => alert("Error deleting video: " + error));
      }
    });
  });
});
