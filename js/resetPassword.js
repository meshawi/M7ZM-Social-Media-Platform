document
  .getElementById("resetForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); 

    const formData = new FormData(this);
    fetch("../backend/reset_password.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        // Clear previous errors
        document.getElementById("username_error").textContent = "";
        document.getElementById("restore_key_error").textContent = "";
        document.getElementById("password_error").textContent = "";

        if (data.success) {
          alert("Password reset successfully!");
          window.location.href = "login.php"; 
        } else {
          // Show error messages
          if (data.errors.username) {
            document.getElementById("username_error").textContent =
              data.errors.username;
          }
          if (data.errors.restore_key) {
            document.getElementById("restore_key_error").textContent =
              data.errors.restore_key;
          }
          if (data.errors.new_password) {
            document.getElementById("password_error").textContent =
              data.errors.new_password;
          }
        }
      })
      .catch((error) => console.error("Error:", error));
  });
