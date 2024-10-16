<?php
require_once('includes/config.php');
session_start();
if (!isset($_SESSION['userID'])) {
  header("Location: loginpage.php");
  exit;
} else {
  $user_id =  $_SESSION['userID'];

  try {
    $sql = "SELECT userID, firstname, middlename, lastname, email, userPosition, phoneNum,address, profilepic FROM user_login WHERE userID=?";
    $stmt = $conn->prepare($sql);
    $data = array($user_id);
    $stmt->execute($data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      $aid = $result["userID"];
      $firstname = $result["firstname"];
      $lastname = $result["lastname"];
      $email = $result["email"];
      $phoneNum = $result["phoneNum"];
      $address = $result["address"];
      $userPosition = $result["userPosition"];
      $image = $result["profilepic"];
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  try {
    $id = $_SESSION['userID'];
    $sql = "SELECT profilepic FROM user_login WHERE userID=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $stmt->bindColumn(1, $profilepic, PDO::PARAM_LOB);
    $stmt->fetch(PDO::FETCH_BOUND);

    // header("Content-Type: image/jpeg");
    echo $profilepic;
  } catch (\Throwable $th) {
    throw $th;
  }
  $con = null;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profile Information</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/logoSIT.png" rel="icon">
  
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="fontawesome/css/all.min.css">

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
  <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
  <script src="jquery/dist/jquery.min.js"></script>
  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<style>
  /* Center modal vertically and horizontally */
  .modal-dialog {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
  }

  /* Adjust modal size */
  .modal-dialog-centered {
    max-width: 500px;
  }

  /* Custom modal content styling */
  .modal-content {
    padding: 20px;
  }

  #floatingAlert {
    position: fixed;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    /* right: 0; */
    /* top: 10%; */
    z-index: 1;
    /* padding: 10px; */
    border-radius: 5px;
    text-align: center;
  }
</style>

<body>

  <!-- ======= Header ======= -->
  <?php require_once('includes/navbar.php'); ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php require_once('includes/sidebar.php'); ?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <div class="col col-md-6">
      <!-- <div class="alert-message"></div> -->
      <div id="floatingAlert"></div>
    </div>
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="Profile" id="cardImage" class="rounded-circle">
              <h2 id="cardFullName"><?php echo $firstname . ' ' . $lastname ?></h2>
              <h3 id="cardUserPosition"><?php echo $userPosition ?></h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <!-- <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                </li> -->

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>

              <div class="tab-content pt-2">



                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic">
                    <!-- Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde. -->
                  </p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8" id="overviewFullName"> <?= $firstname . ' ' . $lastname ?></div>

                  </div>

                  <!-- <div class="row">
                    <div class="col-lg-3 col-md-4 label">Company</div>
                    <div class="col-lg-9 col-md-8">Sierra Vision</div>
                  </div> -->

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8" id="overviewUserPosition"><?= $userPosition ?></div>
                  </div>

                  <!-- <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8">Philippines</div>
                  </div> -->
                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8" id="overviewEmail"><?= $email ?></div>
                  </div>



                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8" id="overviewPhoneNum"><?= $phoneNum ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8" id="overviewAddress"><?= $address ?></div>
                  </div>
                </div>


                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                  <!-- Profile Edit Form -->
                  <form id="myForm" method="POST" action="update-user-profile.php" enctype="multipart/form-data">
                    <input type="hidden" name="txtID" value="<?= $aid ?>">
                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <!-- <img id="profile-preview" src="get-profile-image.php?id=<?= $aid ?>" alt="Profile" style="max-width: 150px;"> -->
                        <img id="profile-preview" src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="Profile" style="max-width: 150px;">
                        <div class="pt-2">
                          <div class="form-group col-md-3">
                            <label class="btn btn-primary btn-sm" title="Upload new profile image">
                              <i class="bi bi-upload"></i>
                              <input type="file" id="profileImage" name="img" style="display: none;" onchange="previewImage(event)" />
                            </label>
                          </div>
                          <div class="form-group col-md-3">
                            <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image">
                              <i class="bi bi-trash"></i>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="fullName" type="text" class="form-control" id="fullName" required value="<?= $firstname; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="lastName" type="text" class="form-control" id="lastName" required value="<?= $lastname; ?>">
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="userPosition" class="col-md-4 col-lg-3 col-form-label">Job</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="userPosition" type="text" class="form-control" id="userPosition" required value="<?= $userPosition; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" required value="<?= $email; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" required value="<?= $phoneNum; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="address" type="text" class="form-control" id="Address" required value="<?= $address; ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                  </form>

                  <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true" data-bs-backdrop="static">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="messageModalLabel">Message</h5>
                        </div>
                        <div class="modal-body" id="messageBody">

                        </div>
                        <!-- <div class="modal-footer">
                          <button type="button" class="btn btn-primary" id="okButton">OK</button>
                        </div> -->
                      </div>
                    </div>
                  </div>

                  <!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-settings">

                  <!-- Settings Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                      <div class="col-md-8 col-lg-9">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="changesMade" checked>
                          <label class="form-check-label" for="changesMade">
                            Changes made to your account
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newProducts" checked>
                          <label class="form-check-label" for="newProducts">
                            Information on new products and services
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="proOffers">
                          <label class="form-check-label" for="proOffers">
                            Marketing and promo offers
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                          <label class="form-check-label" for="securityNotify">
                            Security alerts
                          </label>
                        </div>
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End settings Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
  require_once('includes/footer.php');
  ?>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="js/automatic_logout.js"></script>
  <script>
    function previewImage(event) {
      var reader = new FileReader();
      reader.onload = function() {
        var output = document.getElementById('profile-preview');
        output.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }

    // $(document).ready(function() {
    //   // Handle OK button click event
    //   $('#okButton').click(function() {
    //     // Close the modal
    //     $('#messageModal').modal('hide');
    //   });
    // });
    function showAlert(message) {
      var successMessage = message;
      var alertClass = 'alert-success';
      var successAlert = document.createElement('div');
      successAlert.classList.add('alert', alertClass);
      successAlert.setAttribute('role', 'alert');
      successAlert.textContent = successMessage;

      document.getElementById('floatingAlert').appendChild(successAlert);

      setTimeout(function() {
        successAlert.remove();
      }, 1500);
    }

    // function showMessage(message) {
    //   $('#messageBody').text(message);
    //   $('#messageModal').modal('show');
    //   setTimeout(function() {
    //     $('#messageModal').modal('hide');
    //     getUserProfileInfo();
    //   }, 800);
    // }

    function getUserProfileInfo() {
      $.ajax({
        type: "POST",
        url: "fetch_user_profile_data.php",
        dataType: "json",
        success: function(response) {
          console.log(response.profilepic);
          if (!response.error) {
            $('#cardFullName').text(response.fullName);
            $('#cardUserPosition').text(response.userPosition);
            $('#cardImage').attr('src', 'get_user_profile_image.php');
            $('#overviewUserPosition').text(response.userPosition);
            $('#overviewFullName').text(response.fullName);
            $('#overviewEmail').text(response.email);
            $('#overviewPhoneNum').text(response.phoneNum);
            $('#overviewAddress').text(response.address);
            $('#navbarImage').attr('src', 'get_user_profile_image.php');
            $('#navbarFullName').text(response.navFullName);
            $('#navFullName').text(response.fullName);
            $('#navPosition').text(response.userPosition);
          } else {
            console.error("Error: " + response.error);
          }
        },
        error: function(xhr, status, error) {
          console.error("Failed to retrieve user profile: " + error);
        }
      });
    }

    $('#myForm').submit(function(event) {
      event.preventDefault();
      $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
          showAlert("Personal Information has been updated.");
          getUserProfileInfo();
          $('.nav-item [data-bs-target="#profile-overview"]').click();
        },
        error: function(xhr, status, error) {
          showMessage("Error occurred: " + error);
        }
      });
    });
  </script>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <!-- <script src="assets/js/main.js"></script> -->

</body>

</html>