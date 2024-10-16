<?php
require_once('includes/config.php');

session_start();
if(isset($_SESSION['userID'])) {
    header("Location: loginpage.php");
    exit;
}
try {
  // Prepare the SQL statement to fetch the latest pH level data from your database
  $sql = "SELECT pH_level, tds_level, water_temperature, air_temperature, air_humidity, ec_level, timestamp FROM hydro_parameters ORDER BY id DESC LIMIT 1";
  $stmt = $conn->prepare($sql);

  // Execute the statement
  $stmt->execute();

  // Fetch the result
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
    $tds_level = number_format($row['tds_level'], 2);
    $ec_level = number_format($tds_level / 500, 2);
    $pH_level = number_format($row['pH_level'], 2);
    $water_temperature = number_format($row['water_temperature'], 2);
    $air_temperature = number_format($row['air_temperature'], 2);
    $air_humidity = number_format($row['air_humidity'], 2);
    $timestamp = $row['timestamp'];
  } else {
    // Default values if no data is found
    $tds_level = '0.00';
    $pH_level = '0.00';
    $ec_level = '0.00';
    $water_temperature = '0.00';
    $air_temperature = '0.00';
    $air_humidity = '0.00';
    $timestamp = '0.00';
  }
} catch (PDOException $e) {
  // Handle errors
  echo "Error: " . $e->getMessage();
}

$conn = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Smart Hydroponics</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">

  <!-- Favicons -->
  <link href="assets/img/logoSIT.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
  <script src="jquery/dist/jquery.min.js"></script>

</head>
<style>
  sup {
    font-size: smaller;
    vertical-align: sub;
  }
</style>

<script>
  $(document).ready(function() {
    function fetchSensorData() {
      $.ajax({
        type: "GET",
        url: "long_polling.php",
        dataType: "json",
        success: function(data) {
          $('#tds_level').html(parseFloat(data.tds_level).toFixed(2) + ' <sup>ppm</sup>');
          $('#pH_level').html(parseFloat(data.pH_level).toFixed(2) + ' <sup>pH</sup>');
          $('#ec_level').html(parseFloat(data.ec_level).toFixed(2) + ' <sup>µS/cm</sup>');
          $('#water_temperature').html(parseFloat(data.water_temperature).toFixed(2) + '<sup>°C</sup>');
          $('#air_temperature').html(parseFloat(data.air_temperature).toFixed(2) + '<sup>°C</sup>');
          $('#air_humidity').html(parseFloat(data.air_humidity).toFixed(2) + '<sup>%</sup>');

          console.log("Sensor data updated successfully.");

          setTimeout(fetchSensorData, 240000);
        },
        error: function(xhr, status, error) {
          console.error("Failed to fetch sensor data: " + error);
          setTimeout(fetchSensorData, 5000);
        }
      });
    }

    fetchSensorData();
  });
</script>


<body>
  <!-- ======= Header ======= -->
  <?php
  require_once('includes/navbar.php');
  ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li> <!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="controls.php">
          <i class="bi bi-journal-text"></i>
          <span>Controls</span>
        </a>
      </li> <!-- End Components Nav -->


      <li class="nav-heading">Account Settings</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li> <!-- End Profile Nav -->
    </ul>
  </aside> <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div> <!-- End Page Title -->

    <section class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">Total Dissolved Solids (TDS)</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="tds_level"><?= $tds_level; ?> <sup>ppm</sup></h5>
                <p class="card-text"><?= $timestamp; ?></p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">pH Level</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="pH_level"><?= $pH_level; ?> <sup>pH</sup></h5>
                <p class="card-text"><?= $timestamp; ?></p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">EC Level</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="ec_level"><?= $ec_level; ?> <sup>µS/cm</sup></h5>
                <p class="card-text"><?= $timestamp; ?></p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">Water Temperature</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="water_temperature"><?= $water_temperature; ?><sup>°C</sup></h5>
                <p class="card-text"><?= $timestamp; ?></p>
              </div>
              <!-- <div class="col mb-1">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                <label class="form-check-label" for="flexSwitchCheckChecked">ON</label>
              </div>
            </div> -->
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">Ambient Temperature</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="air_temperature"><?= $air_temperature; ?> <sup>°C</sup></h5>
                <p class="card-text"><?= $timestamp; ?></p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">Relative Humidity</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title"><?= $air_humidity; ?><sup>%</sup></h5>
                <p class="card-text"><?= $timestamp; ?></p>
              </div>
            </div>
          </div>

          <!-- <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">Water Flow</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="water_flow">620.21 <sup>l/min</sup></h5>
                <p class="card-text">8/8 16:41:34</p>
              </div>
            </div>
          </div> -->

          <!-- <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">Water Level</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title">0.00 <sup>bool</sup></h5>
                <p class="card-text">8/8 16:41:50</p>
              </div>
            </div>
          </div> -->

        </div> <!-- End Row -->

        <!-- <div class="row mt-4">

          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">Vapor PD</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="vapor_pd">1.85 <sup>kPa</sup></h5>
                <p class="card-text">8/8 16:42:10</p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">C02</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="co2">1572.00 <sup>ppm</sup></h5>
                <p class="card-text">8/8 16:42:10</p>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card">
              <div class="card-header text-center">
                <span class="text-center">Outside Temp</span>
              </div>
              <div class="card-body text-center text-success">
                <h5 class="card-title" id="outside_temperature">102.81<sup>°F</sup></h5>
                <p class="card-text">8/8 16:42:10</p>
              </div>
            </div>
          </div>

        </div> End Row -->

      </div> <!-- End Container -->
    </section>

  </main> <!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <script src="assets/js/main.js"></script>
  <!-- Template Main JS File -->
  <script src="js/bootstrap.bundle.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>

</html>