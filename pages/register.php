<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>Register on m7zm-clips</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>

    </style>
</head>

<body> <?php require ("./navbar.php"); ?>
    <link rel="stylesheet" href="../css/register.css">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4 text-center title">Register on m7zm-clips</h2>
                <form action="../backend/register.php" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="profileImage" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="profileImage" name="profileImage" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-primary btn-primaryS">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>