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

    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php require ("./navbar.php"); ?>
    <link rel="stylesheet" href="../css/edit_profile.css">

    <div class="container mt-5">
        <div class="profile-card text-center">
            <div class="profile-image mb-4">
                <img src="path_to_default_image.jpg" alt="Profile Image" id="profileImage" class="img-fluid">
            </div>
            <h2>User Profile</h2>

            <div class="mx-auto" style="max-width: 450px;">
                <form id="updateUsernameForm" class="mb-3">
                    <div class="icon-input">
                        <i class="bi bi-person-circle"></i>
                        <input type="text" class="form-control" placeholder="New Username" id="username" name="username"
                            required>
                        <input type="hidden" name="action" value="updateUsername">

                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Update Username</button>
                </form>

                <form id="updatePasswordForm" class="mb-3">
                    <div class="icon-input">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" class="form-control" placeholder="New Password" id="password"
                            name="password" required>
                        <input type="hidden" name="action" value="updatePassword">

                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Update Password</button>
                </form>

                <form id="updateFullnameForm" class="mb-3">
                    <div class="icon-input">
                        <i class="bi bi-card-text"></i>
                        <input type="text" class="form-control" placeholder="New Full Name" id="fullname"
                            name="fullname" required>
                        <input type="hidden" name="action" value="updateFullname">

                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Update Full Name</button>
                </form>

                <form id="updateBioForm" class="mb-3">
                    <div class="icon-input">
                        <i class="bi bi-chat-left-text-fill"></i>
                        <textarea class="form-control" placeholder="New Bio" id="bio" name="bio" required
                            style="height: 100px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Update Bio</button>
                </form>

                <form id="uploadProfileImageForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="file" class="form-control" id="profileImageFile" name="profileImageFile"
                            accept="image/*" required>
                        <input type="hidden" name="action" value="updateProfileImage">

                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upload Image</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../js/profile.js"></script>
</body>

</html>