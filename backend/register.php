<?php
require_once 'config.php';

$username = $fullname = $password = "";
$username_err = $fullname_err = $password_err = $profile_image_err = "";
$profile_image_path = "/storage/profile_images/defualt.jpg";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $fullname = trim($_POST['fullname']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    if (isset($_FILES["profileImage"]) && $_FILES["profileImage"]["error"] == 0) {
        $allowed = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];
        $filename = $_FILES["profileImage"]["name"];
        $filetype = $_FILES["profileImage"]["type"];
        $filesize = $_FILES["profileImage"]["size"];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            echo "Error: Please select a valid file format.";
            exit;
        }

        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            echo "Error: File size is larger than the allowed limit.";
            exit;
        }

        $new_filename = uniqid() . '-' . basename($filename);
        $target_path = "../storage/profile_images/" . $new_filename;

        if (in_array($filetype, $allowed)) {
            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $target_path)) {
                $profile_image_path = "../storage/profile_images/" . $new_filename;
            } else {
                echo "Error: There was a problem uploading your file. Please try again.";
                exit;
            }
        } else {
            echo "Error: Invalid file type.";
            exit;
        }
    } else {
        echo "Error: " . $_FILES["profileImage"]["error"];
    }

    $sql = "INSERT INTO users (username, fullname, password, profile_image) VALUES (?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $username, $fullname, $password, $profile_image_path);
        if (mysqli_stmt_execute($stmt)) {
            header("location: ../pages/login.php");
        } else {
            echo "Error: Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>
