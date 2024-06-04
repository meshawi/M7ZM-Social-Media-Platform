<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid">
  <header
    class="navbar navbar-expand-md navbar-light d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom">
    <a href="../index.html" class="navbar-brand">
      <img src="../assets/uciLogo.png" alt="UCI Logo" width="40" height="40" class="d-inline-block align-text-top">
    </a>

    <!-- Add data-bs-toggle and data-bs-target attributes to the navbar toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a href="./home.php"
            class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'link-primary' : 'link-secondary'; ?>">Home</a>
        </li>
        <li class="nav-item">
          <a href="./watch_videos.php"
            class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'watch_videos.php' ? 'link-primary' : 'link-secondary'; ?>">Watch
            Clips</a>
        </li>
        <li class="nav-item">
          <a href="./gallery.php"
            class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'link-primary' : 'link-secondary'; ?>">Images
            Gallery</a>
        </li>
        <li class="nav-item">
          <a href="./cod.php"
            class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'cod.php' ? 'link-primary' : 'link-secondary'; ?>">COD</a>
        </li>
        <li class="nav-item">
          <a href="./games.php"
            class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'games.php' ? 'link-primary' : 'link-secondary'; ?>">Games</a>
        </li>
        <li class="nav-item">
          <a href="./customGames.php"
            class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'customGames.php' ? 'link-primary' : 'link-secondary'; ?>">Custom
            Games</a>
        </li>
        <li class="nav-item">
          <a href="./trjmh.php"
            class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'trjmh.php' ? 'link-primary' : 'link-secondary'; ?>">TRJMH</a>
        </li>
      </ul>

      <div class="text-md-end">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
          <a href="../backend/logout.php" class="btn btn-danger">Logout</a>
          <a href="../pages/my_account.php" class="btn btn-primary">My Account</a>
        <?php else: ?>
          <a href="../pages/register.php" class="btn btn-danger">Register</a>
          <a href="../pages/login.php" class="btn btn-primary">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </header>
</div>
<script>
  // Add click event listener to navbar toggler icon
  var navbarToggler = document.querySelector('.navbar-toggler');
  navbarToggler.addEventListener('click', function () {
    var navbarCollapse = document.querySelector('#navbarNav');
    navbarCollapse.classList.toggle('show'); // Toggle the 'show' class on navbar collapse
  });
</script>