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
const forms = document.querySelectorAll("form");
forms.forEach((form) => {
  form.addEventListener("submit", function (event) {
    event.preventDefault(); 
    const formData = new FormData(this);
    fetch("../backend/update_user.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        alert(data.message);
        if (data.success && data.profile_image) {
          document.getElementById("profileImage").src = data.profile_image;
        }
      })
      .catch((error) => console.error("Error:", error));
  });
});
