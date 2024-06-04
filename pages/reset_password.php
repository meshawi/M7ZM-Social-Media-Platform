<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <?php require ("./navbar.php"); ?>
    <link rel="stylesheet" href="../css/resetpass.css">
    <div class="cardContainer">

        <div class="col-md-6 ">
            <div class="card">
                <div class="card-header text-center">
                    <h3><i class="fas fa-unlock-alt"></i> Reset Password</h3>
                </div>
                <div class="card-body">
                    <form id="resetForm">
                        <div class="form-group">
                            <label for="username"><i class="fas fa-user"></i> Username</label>
                            <input type="text" name="username" class="form-control" required>
                            <div class="invalid-feedback" id="username_error">Please enter your username.</div>
                        </div>
                        <div class="form-group">
                            <label for="restore_key"><i class="fas fa-key"></i> Restore Key</label>
                            <input type="text" name="restore_key" class="form-control" required>
                            <div class="invalid-feedback" id="restore_key_error">Please enter your restore key.</div>
                        </div>
                        <div class="form-group">
                            <label for="new_password"><i class="fas fa-lock"></i> New Password</label>
                            <input type="password" name="new_password" class="form-control" required>
                            <div class="invalid-feedback" id="password_error">Please enter a new password.</div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>