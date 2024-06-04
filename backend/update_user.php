<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Session not set']);
    exit;
}

$user_id = $_SESSION['id'];
$response = ['success' => false, 'message' => 'Update failed'];

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'updateUsername':
        $username = trim($_POST['username'] ?? '');
        if (empty($username)) {
            $response['message'] = 'Username cannot be empty';
            echo json_encode($response);
            exit;
        }
        $sql = "UPDATE users SET username = ? WHERE id = ?";
        $param = $username;
        break;
    case 'updatePassword':
        $password = trim($_POST['password'] ?? '');
        if (empty($password)) {
            $response['message'] = 'Password cannot be empty';
            echo json_encode($response);
            exit;
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $param = $hashed_password;
        break;
    case 'updateFullname':
        $fullname = trim($_POST['fullname'] ?? '');
        if (empty($fullname)) {
            $response['message'] = 'Fullname cannot be empty';
            echo json_encode($response);
            exit;
        }
        $sql = "UPDATE users SET fullname = ? WHERE id = ?";
        $param = $fullname;
        break;
        case 'updateBio':
            $bio = trim($_POST['bio'] ?? '');
            if (empty($bio)) {
                $response['message'] = 'Bio cannot be empty';
                echo json_encode($response);
                exit;
            }
            $sql = "UPDATE users SET bio = ? WHERE id = ?";
            $param = $bio;
            break;
        
    case 'updateProfileImage':
        $profileImageFile = $_FILES['profileImageFile'] ?? null;
        if (!$profileImageFile || $profileImageFile['error'] !== UPLOAD_ERR_OK) {
            $response['message'] = 'Invalid file upload';
            echo json_encode($response);
            exit;
        }
        $filename = time() . '-' . basename($profileImageFile['name']);
        $filePath = "../storage/profile_images/" . $filename;
        if (!move_uploaded_file($profileImageFile['tmp_name'], $filePath)) {
            $response['message'] = 'Failed to upload image';
            echo json_encode($response);
            exit;
        }
        $sql = "UPDATE users SET profile_image = ? WHERE id = ?";
        $param = $filePath;
        break;
    default:
        $response['message'] = 'Action not recognized';
        echo json_encode($response);
        exit;
}

if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "si", $param, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
        $response['message'] = 'Update successful';
        if ($action === 'updateProfileImage') {
            $response['profile_image'] = $filePath; 
        }
    } else {
        $response['message'] = 'Execution error: ' . mysqli_error($link);
    }
    mysqli_stmt_close($stmt);
} else {
    $response['message'] = 'Preparation error: ' . mysqli_error($link);
}
echo json_encode($response);
mysqli_close($link);
?>
