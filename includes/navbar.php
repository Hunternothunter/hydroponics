<?php
require_once('includes/config.php');

// session_start();
$userID = $_SESSION['userID'];

try {
  $sql = "SELECT CONCAT(SUBSTRING(firstname, 1, 1), '. ', lastname) full_name, CONCAT(firstname, ' ', lastname) AS fullName, userPosition FROM user_login WHERE userID=?";
  $stmt = $conn->prepare($sql);
  $data = array($userID);
  $stmt->execute($data);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($result) {
    $full_name = $result['full_name'];
    $fullName = $result['fullName'];
    $userPosition = $result['userPosition'];
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
  // exit();
}
?>
<style>
  .icon-wrapper {
    width: 60px;
    /* Adjust as needed */
    height: 40px;
    /* Adjust as needed */
    border-radius: 30px 30px 0 0;
    /* Arc shape */
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background-color 0.3s;
    /* Smooth transition */
  }

  .icon-wrapper.active {
    /* background-color: #007bff; */
    background-color: #F5F5F5;
    /* Your primary color */
    color: #007bff;
    /* Change icon color when active */
  }

  .text-wrapper {
    display: block;
    width: 100%;
    border-radius: 5px 5px 0 0;
    /* Full width for the background */
    text-align: center;
    /* Center the text */
    /* padding: 5px 0; */
    /* Vertical padding for the text */
    transition: background-color 0.3s;
    /* Smooth transition */
  }

  .text-wrapper.active {
    /* background-color: #007bff; */
    background-color: #F5F5F5;
    /* Same primary color for the text background */
    color: #007bff;
    /* White text */
  }
</style>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="gauge-index.php" class="logo d-flex align-items-center">
      <img src="assets/img/logoSIT.png" alt="">
      <span class="d-none d-lg-block">SIT - Admin</span>
    </a>
    <i class="d-none d-sm-block bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <!-- <img src="assets/img/profile-img.png" alt="Profile" class="rounded-circle"> -->
          <img src="get_user_profile_image.php" alt="Profile" id="navbarImage" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2" id="navbarFullName"><?= $full_name ?></span>
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

          <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li> -->
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
              <i class="bi bi-question-circle"></i>
              <span>Need Help?</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="logout.php">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>

            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

  <div class="d-block d-sm-none">
    <div class="position-fixed bottom-0 start-0 end-0 bg-light border-top" style="z-index: 1050">
      <div class="container py-2">
        <div class="d-flex justify-content-around">

          <div class="text-center">
            <a href="gauge-index.php" class="<?php echo ($currentRoute === 'dashboard') ? 'nav-link active text-dark border-bottom border-3 border-primary' : 'nav-link text-muted hover-link'; ?>">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-wrapper <?php echo ($currentRoute === 'dashboard') ? 'active' : ''; ?>">
                  <i class="fas fa-tachometer-alt" style="font-size: 1.67em;"></i>
                </div>
                <span class="ps-2 pe-2 pb-2 fw-bold text-wrapper <?php echo ($currentRoute === 'dashboard') ? 'active' : ''; ?>">Dashboard</span>
              </div>
            </a>
          </div>

          <div class="text-center">
            <a href="controls.php" class="<?php echo ($currentRoute === 'controls') ? 'nav-link active text-dark border-bottom border-3 border-primary' : 'nav-link text-muted hover-link'; ?>">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-wrapper <?php echo ($currentRoute === 'controls') ? 'active' : ''; ?>">
                  <i class="fas fa-sliders-h" style="font-size: 1.67em;"></i>
                </div>
                <span class="ps-2 pe-2 pb-2 fw-bold text-wrapper <?php echo ($currentRoute === 'controls') ? 'active' : ''; ?>">Controls</span>
              </div>
            </a>
          </div>

          <div class="text-center">
            <a href="historical-data.php" class="<?php echo ($currentRoute === 'historical') ? 'nav-link active text-dark border-bottom border-3 border-primary' : 'nav-link text-muted hover-link'; ?>">
              <div class="d-flex flex-column align-items-center">
                <div class="icon-wrapper <?php echo ($currentRoute === 'historical') ? 'active' : ''; ?>">
                  <i class="fas fa-history" style="font-size: 1.67em;"></i>
                </div>
                <span class="ps-2 pe-2 pb-2 fw-bold text-wrapper <?php echo ($currentRoute === 'historical') ? 'active' : ''; ?>">Historical Data</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header><!-- End Header -->