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
    <title>Search User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php require ("./navbar.php") ?>
    <link rel="stylesheet" href="../css/search_user.css">

    <div class="container mt-4">
        <h1>Search User</h1>
        <form id="searchForm">
            <div class="mb-3">
                <label for="usernameInput" class="form-label">Enter Username</label>
                <input type="text" class="form-control" id="usernameInput" placeholder="Username" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form submission

            // Get the value of the username input field
            const username = document.getElementById('usernameInput').value.trim();

            // Perform an AJAX request to fetch the user ID based on the username
            fetch(`../backend/get_user_id.php?username=${encodeURIComponent(username)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const userId = data.user_id;
                        // Redirect to the user account page with the user ID as a query parameter
                        window.location.href = `user_account.php?user_id=${userId}`;
                    } else {
                        alert('User not found! Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching user ID:', error);
                    alert('Error fetching user ID. Please try again.');
                });
        });
    </script>
</body>

</html>