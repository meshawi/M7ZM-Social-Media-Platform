<?php
session_start();
require_once "config.php";

$username = $password = "";
$errors = ['username' => '', 'password' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username)) {
        $errors['username'] = "Please enter username.";
    }

    if (empty($password)) {
        $errors['password'] = "Please enter your password.";
    }

    if (empty($errors['username']) && empty($errors['password'])) {
        $sql = "SELECT id, username, password, accessibility FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $accessibility);
                    if (mysqli_stmt_fetch($stmt)) {
                        // Debugging statements
                        error_log("Fetched hashed password: $hashed_password");
                        error_log("Fetched accessibility: $accessibility");
                        error_log("Entered password: $password");

                        if (password_verify($password, $hashed_password) && $accessibility == 1) {
                            // Update user status to online and last seen
                            $update_sql = "UPDATE users SET status = 'online', last_seen = CURRENT_TIMESTAMP WHERE id = ?";
                            if ($update_stmt = mysqli_prepare($link, $update_sql)) {
                                mysqli_stmt_bind_param($update_stmt, "i", $id);
                                mysqli_stmt_execute($update_stmt);
                                mysqli_stmt_close($update_stmt);
                            }

                            session_regenerate_id();
                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['username'] = $username;
                            echo json_encode(['success' => true]);
                        } else {
                            error_log("Password verify or accessibility failed");
                            $errors['password'] = "Invalid password or your account is not accessible.";
                            echo json_encode(['success' => false, 'errors' => $errors]);
                        }
                    }
                } else {
                    error_log("No account found with that username");
                    $errors['username'] = "No account found with that username.";
                    echo json_encode(['success' => false, 'errors' => $errors]);
                }
            } else {
                error_log("Database error during statement execution");
                echo json_encode(['success' => false, 'errors' => ['database' => 'Database error']]);
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
    mysqli_close($link);
}
?>