<?php
require_once 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$errors = array('username' => '', 'restore_key' => '', 'new_password' => '');
$data = $_POST;

if (empty(trim($data["username"]))) {
    $errors['username'] = "Please enter your username.";
} else {
    $username = trim($data["username"]);
}

if (empty(trim($data["restore_key"]))) {
    $errors['restore_key'] = "Please enter your restore key.";
} else {
    $restore_key = trim($data["restore_key"]);
}

if (empty(trim($data["new_password"]))) {
    $errors['new_password'] = "Please enter the new password.";
} else {
    $new_password = trim($data["new_password"]);
}

if (!array_filter($errors)) {
    $sql = "SELECT users.id FROM users JOIN restorekeys ON users.username = ? AND restorekeys.restore_key = ? AND restorekeys.valid = 1";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $restore_key);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {
                $sql = "UPDATE users SET password = ? WHERE username = ?";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ss", $param_password, $username);

                    if (mysqli_stmt_execute($stmt)) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Password could not be updated.']);
                    }
                }
            } else {
                $errors['username'] = "Invalid username or restore key.";
                echo json_encode(['success' => false, 'errors' => $errors]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error on checking user and key.']);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database preparation error.']);
    }
} else {
    echo json_encode(['success' => false, 'errors' => $errors]);
}

mysqli_close($link);
?>
