document
  .getElementById("loginForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    fetch("../backend/login.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        document.getElementById("username_error").textContent = "";
        document.getElementById("password_error").textContent = "";

        if (data.success) {
          window.location.href = "../pages/home.php";
        } else {
          if (data.errors.username) {
            document.getElementById("username_error").textContent =
              data.errors.username;
          }
          if (data.errors.password) {
            document.getElementById("password_error").textContent =
              data.errors.password;
          }
        }
      })
      .catch((error) => console.error("Error:", error));
  });
