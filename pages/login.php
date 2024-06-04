<?php
// Start session and include config
session_start();
require_once "../backend/config.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle login logic here
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>Login to m7zm-clips</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require ("./navbar.php"); ?>
    <link rel="stylesheet" href="../css/login.css">

    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            <form id="loginForm">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <div class="text-danger" id="username_error"></div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="text-danger" id="password_error"></div>
                </div>
                <button type="submit" class="btn btn-primary lgbtn">Login</button>
            </form>
            <p>Forget the password? <a href="reset_password.php">Forget Password</a>.</p>
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </div>
    </div>

    <script src="../js/login.js"></script>
</body>

</html>