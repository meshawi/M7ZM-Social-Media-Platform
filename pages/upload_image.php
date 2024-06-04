<?php
session_start();
require_once '../backend/auth_check.php';
include '../backend/functions.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
  <link rel="icon" type="image/png" href="../assets/uciLogo.png" />

  <title>Upload image</title>
</head>

<body>
  <?php require ("./navbar.php") ?>

  <!-- Link to Bootstrap and custom styles -->
  <link rel="stylesheet" href="../css/upload_image.css">



  <div class="container mt-4">
    <h2>Upload Image</h2>
    <form action="../backend/upload_image.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="description" class="form-label">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image File:</label>
        <input type="file" class="custom-file-input" id="image" name="image" required>
        <label for="image" class="custom-file-label">Choose file...</label>
      </div>
      <div class="mb-3">
        <label class="form-label">Tags:</label>
        <div class="row">
          <?php
          $tags = fetchTags();
          foreach ($tags as $tag) {
            echo '<div class="col-md-3 col-sm-6">';
            echo '<input class="tag-checkbox" type="checkbox" name="tags[]" id="tag' . $tag['id'] . '" value="' . $tag['id'] . '">';
            echo '<label class="btn btn-outline-primary mb-2" for="tag' . $tag['id'] . '">' . htmlspecialchars($tag['name']) . '</label>';
            echo '</div>';
          }
          ?>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-cloud-upload-alt"></i> Upload Image
      </button>
    </form>
  </div>
</body>
<script>
  // Improve the user experience for custom file input
  document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var fileName = document.getElementById("image").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
  });
</script>

</html>