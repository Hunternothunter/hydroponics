<?php
require_once('includes/config.php');

// session_start();
$userID = $_SESSION['userID'];

try {
  $sql = "
  SELECT profilepic, CONCAT(firstname, ' ', lastname) AS fullName, userPosition FROM user_login WHERE userID=?";

  $stmt = $conn->prepare($sql);
  $data = array($userID);
  $stmt->execute($data);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($result) {
    $fullName = $result['fullName'];
    $userPosition = $result['userPosition'];
    $imageName = $result['profilepic'];
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  // exit();
}

$profilepic = $imageName;
?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-center">
    <a href="index.php" class="logo d-flex align-items-center">
      <img src="assets/img/Logo.png" class="rounded-circle" alt="Logo" height="50" width="50">
      <span class="d-none d-lg-block" style="font-size: 1.25rem;">Smart-Hydroponics</span>
    </a>
    <i class="d-none d-sm-block bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <!-- <img src="assets/img/profile-img.png" alt="Profile" class="rounded-circle"> -->
          <img src="public/profile_pictures/<?= htmlspecialchars($imageName); ?>" alt="Profile" id="navbarImage" class="rounded-circle" height="40" width="40">
          <!-- <img src="get_user_profile_image.php" alt="Profile" id="navbarImage" class="rounded-circle"> -->
          <span class="d-none d-md-block dropdown-toggle ps-2" id="navbarFullName"><?= $fullName ?></span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6 id="navFullName"> <?= $fullName ?></h6>
            <span id="navPosition"><?= $userPosition ?></span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <form action="logout.php" method="post">
              <button class="dropdown-item d-flex align-items-center" type="submit">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>

              </button>
            </form>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->
</header><!-- End Header -->

<script>
  document.addEventListener('contextmenu', event => event.preventDefault());

  document.onkeydown = function(e) {
    if (e.key === "F12") {
      return false; // Disable F12
    }
  };
</script>