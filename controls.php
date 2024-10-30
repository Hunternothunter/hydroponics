<?php
require_once('includes/config.php');
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}
function getControlStatesFromDatabase($conn)
{
    $controlStates = array();
    $sql = "SELECT component_name, dispense_amount FROM components_control";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $componentName = $row["component_name"];
        $controlStatus = $row["dispense_amount"];
        $controlStates[$componentName] = $controlStatus;
    }

    return $controlStates;
}

$controlStates = getControlStatesFromDatabase($conn);
// $conn = null;

$currentRoute = "controls";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Controls</title>
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


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="jquery/dist/jquery.min.js"></script>

</head>
<style>
    sup {
        font-size: smaller;
    }

    .custom-switch {
        width: 3rem !important;
        /* Adjust width as needed */
        height: 1.5rem;
        /* Adjust height as needed */
    }

    .card-body {
        padding: 1rem;
    }

    .component-name {
        font-size: 1rem;
    }

    .switch-btn {
        font-size: 1rem;
    }

    @media screen and (max-width: 768px) {
        .component-name {
            font-size: 0.8rem;
        }

        .switch-btn {
            font-size: 0.8rem;
        }
    }

    i {
        color: #4154f1;
    }

    #floatingAlert {
        position: fixed;
        /* top: 50px; */
        /* left: 50%; */
        /* transform: translateX(-50%); */
        right: 0;
        top: 10%;
        z-index: 9999;
        padding: 10px;
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
            <h1>Controls</h1>
            <div class="row">
                <div class="col col-md-6">
                    <!-- <div class="alert-message"></div> -->
                    <div id="floatingAlert"></div>
                </div>
            </div>
        </div><!-- End Page Title -->
        <?php
        require_once('includes/modal-form.php');
        ?>
        <section class="section">
            <div class="container mt-5">
                <div class="row justify-content-center">

                    <div class="col-md-10">
                        <div class="card">
                            <div class="row">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-light" style="height: 100%; width: 3.5rem;" data-bs-toggle="collapse" data-bs-target="#nutrientADetails" id="toggleButton"><i class="fas fa-plus fa-2x"></i></button>
                                    </div>
                                    <div class="col-md-10">
                                        <span class="component-name">Nutrient A</span>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-switch text-primary">
                                            <input class="form-check-input custom-switch" type="checkbox" id="nutrientA" onclick='toggleComponent("nutrientA", this.checked)'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="nutrientADetails" aria-labelledby="toggleButton">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <sup>Amount to Dispense (ml):</sup> <input type="text" id="nutrient-A" class="form-control">
                                            <input type="hidden" id="nutrientAMinutes" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <br><button type="button" class="btn btn-success" onclick='turnOnComponent("nutrientA", "nutrient-A", "nutrientAMinutes")'>Pump Volume</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="row">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-light" style="height: 100%; width: 3.5rem;" data-bs-toggle="collapse" data-bs-target="#nutrientBDetails" id="toggleButton"><i class="fas fa-plus fa-2x"></i></button>
                                    </div>
                                    <div class="col-md-10">
                                        <span class="component-name">Nutrient B</span>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-switch text-primary">
                                            <input class="form-check-input custom-switch" type="checkbox" id="nutrientB" onclick='toggleComponent("nutrientB", this.checked)'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="nutrientBDetails" aria-labelledby="toggleButton">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <sup>Amount to Dispense (ml):</sup> <input type="text" id="nutrient-B" class="form-control">
                                            <input type="hidden" id="nutrientBMinutes" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <br><button type="button" class="btn btn-success" onclick='turnOnComponent("nutrientB", "nutrient-B", "nutrientBMinutes")'>Pump Volume</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="card">
                            <div class="row">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-light" style="height: 100%; width: 3.5rem;" data-bs-toggle="collapse" data-bs-target="#pumpPhDownDetails" id="toggleButton"><i class="fas fa-plus fa-2x"></i></button>
                                    </div>
                                    <div class="col-md-10">
                                        <span class="component-name">pH Down</sup></span>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-switch text-primary">
                                            <input class="form-check-input custom-switch" type="checkbox" id="pumpPhDown" onclick='toggleComponent("pumpPhDown", this.checked)'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="pumpPhDownDetails" aria-labelledby="toggleButton">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <sup>Amount to Dispense (ml):</sup> <input type="text" id="phDown" class="form-control">
                                            <input type="hidden" id="phDownMinutes" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <br><button type="button" class="btn btn-success" onclick='turnOnComponent("pumpPhDown", "phDown", "phDownMinutes")'>Pump Volume</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="card">
                            <div class="row">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-light" style="height: 100%; width: 3.5rem;" data-bs-toggle="collapse" data-bs-target="#pumpPhUpDetails" id="toggleButton"><i class="fas fa-plus fa-2x"></i></button>
                                    </div>
                                    <div class="col-md-10">
                                        <span class="component-name">pH Up</span>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-switch text-primary">
                                            <input class="form-check-input custom-switch" type="checkbox" id="pumpPhUp" onclick='toggleComponent("pumpPhUp", this.checked)'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="pumpPhUpDetails" aria-labelledby="toggleButton">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <sup>Amount to Dispense (ml):</sup> <input type="text" id="phUp" class="form-control">
                                            <input type="hidden" id="phUpMinutes" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <br><button type="button" class="btn btn-success" onclick='turnOnComponent("pumpPhUp", "phUp", "phUpMinutes")'>Pump Volume</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="card">
                            <div class="row">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-light" style="height: 100%; width: 3.5rem;" data-bs-toggle="collapse" data-bs-target="#purified_waterDetails" id="toggleButton"><i class="fas fa-plus fa-2x"></i></button>
                                    </div>
                                    <div class="col-md-10">
                                        <span class="component-name">Distilled Water</span>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-switch text-primary">
                                            <input class="form-check-input custom-switch" type="checkbox" id="purified_water" onclick='toggleComponent("purified_water", this.checked)'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="purified_waterDetails" aria-labelledby="toggleButton">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <sup>Amount to Dispense (ml):</sup>
                                            <input type="text" class="form-control" id="purified">
                                            <input type="hidden" class="form-control" id="purifiedMinutes">
                                        </div>
                                        <div class="col-md-3">
                                            <br>
                                            <button type="button" class="btn btn-success" onclick='turnOnComponent("purified_water", "purified", "purifiedMinutes")'>Pump Volume</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="card">
                            <div class="row">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-light" style="height: 100%; width: 3.5rem;" data-bs-toggle="collapse" data-bs-target="#waterPumpDetails" id="toggleButton"><i class="fas fa-plus fa-2x"></i></button>
                                    </div>
                                    <div class="col-md-10">
                                        <span class="component-name">Water Pump <sup>(Reservoir)</sup></span>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-switch text-primary">
                                            <input class="form-check-input custom-switch" type="checkbox" id="waterPump" onclick='toggleComponent("waterPump", this.checked)'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="waterPumpDetails" aria-labelledby="toggleButton">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            Hours: <input type="text" class="form-control" id="waterPumpHours">
                                        </div>
                                        <div class="col-md-3">
                                            Minutes: <input type="text" class="form-control" id="waterPumpMinutes">
                                        </div>
                                        <div class="col-md-3">
                                            <br><button type="button" class="btn btn-success" onclick='turnOnComponent("waterPump", "waterPumpHours", "waterPumpMinutes")'>Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <div class="card">
                            <div class="row">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div class="col-md-1">
                                        <button class="btn btn-sm btn-light" style="height: 100%; width: 3.5rem;" data-bs-toggle="collapse" data-bs-target="#growLightDetails" id="toggleButton"><i class="fas fa-plus fa-2x"></i></button>
                                    </div>
                                    <div class="col-md-10">
                                        <span class="component-name">Grow Light</span>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-check form-switch text-primary">
                                            <input class="form-check-input custom-switch" type="checkbox" id="growLight" onclick='toggleComponent("growLight", this.checked)'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="growLightDetails" aria-labelledby="toggleButton">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            Hours: <input type="text" class="form-control" id="growLightHours">
                                        </div>
                                        <div class="col-md-3">
                                            Minutes: <input type="text" class="form-control" id="growLightMinutes">
                                        </div>
                                        <div class="col-md-3">
                                            <br><button type="button" class="btn btn-success" onclick='turnOnComponent("growLight", "growLightHours", "growLightMinutes")'>Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php require_once('includes/mobile-nav.php'); ?>

    <?php
    // require_once('includes/footer.php'); 
    ?>


    <!-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="js/automatic_logout.js"></script> -->
    <script>
        function ChangeIcon() {
            var toggleButtons = document.querySelectorAll('[id^="toggleButton"]');

            toggleButtons.forEach(function(toggleButton) {
                toggleButton.addEventListener('click', function() {
                    var iconElement = toggleButton.querySelector('i');

                    if (toggleButton.getAttribute('aria-expanded') === 'true') {
                        iconElement.classList.remove('fa-plus');
                        iconElement.classList.add('fa-minus');
                    } else {
                        iconElement.classList.remove('fa-minus');
                        iconElement.classList.add('fa-plus');
                    }
                });
            });
        }

        ChangeIcon();

        // Function to restrict non-numerical input
        function restrictNonNumericalInput(inputField) {
            // Allow only numerical input
            inputField.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Allow only digits
            });

            // Prevent non-numerical characters during keypress
            inputField.addEventListener('keypress', function(event) {
                if (!/[0-9]/.test(event.key) && event.key !== 'Backspace' && event.key !== 'Delete') {
                    event.preventDefault(); // Prevent the input if it's not a digit
                }
            });
        }
        // Apply the restriction to your input fields
        document.addEventListener('DOMContentLoaded', function() {
            var hoursInput = document.getElementById(hoursID);
            var minutesInput = document.getElementById(minutes);

            if (hoursInput) {
                restrictNonNumericalInput(hoursInput);
            }

            if (minutesInput) {
                restrictNonNumericalInput(minutesInput);
            }
        });

        function turnOnComponent(componentName, hoursID, minutesID) {
            var dispenseAmount = 0;
            var hours = parseFloat(document.getElementById(hoursID).value) || 0;
            var minutes = parseFloat(document.getElementById(minutesID).value) || 0;

            // Check for negative values
            if (hours < 0 || minutes < 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid input',
                    text: 'Value must be non-negative.',
                    timer: 1300,
                    showConfirmButton: false
                });
                // showAlert(componentName, false);
                return;
            }

            // Specific checks for growLight and waterPump
            if (componentName === "growLight" || componentName === "waterPump") {
                // Check if both values are 0
                if (hours <= 0 && minutes <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid input',
                        text: 'At least one value (hours or minutes) must be greater than zero.',
                        timer: 1300,
                        showConfirmButton: false
                    });
                    // Clear input fields
                    document.getElementById(hoursID).value = '';
                    document.getElementById(minutesID).value = '';
                    return;
                }
            } else {
                // For other components, ensure minutes are > 0
                if (hours <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid input',
                        text: 'Value must be greater than zero for this component.',
                        timer: 1300,
                        showConfirmButton: false
                    });
                    return;
                }
            }

            // Calculate dispense amount based on component type
            dispenseAmount = (hours * 3600) + (minutes * 60);

            showAlert(componentName, true);

            // AJAX request to update controls
            $.ajax({
                type: "POST",
                url: "update_controls.php",
                data: {
                    componentName: componentName,
                    dispense_amount: dispenseAmount
                },
                success: function(response) {
                    var inputField = document.querySelector('#' + componentName + 'Details input[type="text"]');
                    var minuteField = document.getElementById(componentName + 'Minutes');

                    if (inputField) {
                        inputField.value = '';
                    }

                    if (minuteField) {
                        minuteField.value = '';
                    }

                    var collapseElement = document.querySelector('#' + componentName + 'Details');
                    if (collapseElement) {
                        var bootstrapCollapse = new bootstrap.Collapse(collapseElement);
                        bootstrapCollapse.hide();
                    }

                    var toggleButton = document.querySelector('[data-bs-target="#' + componentName + 'Details"]');
                    var iconElement = toggleButton.querySelector('i');

                    if (iconElement) {
                        iconElement.classList.remove('fa-minus');
                        iconElement.classList.add('fa-plus');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Failed to turn on component: " + error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to turn on component. Please try again.'
                    });
                }
            });
        }

        var componentNames = {
            pumpPhDown: "pH Down",
            pumpPhUp: "pH Up",
            purified_water: "Distilled Water",
            waterPump: "Water Pump",
            growLight: "Grow Light",
            nutrientA: "Nutrient A",
            nutrientB: "Nutrient B"
        };

        function showAlert(componentID, checked) {
            var componentName = componentNames[componentID];
            var successMessage = checked ? componentName + ' has been turned on!' : componentName + ' has been turned off!';
            var alertClass = checked ? 'alert-success' : 'alert-danger';
            var successAlert = document.createElement('div');
            successAlert.classList.add('alert', alertClass);
            successAlert.setAttribute('role', 'alert');
            successAlert.textContent = successMessage;

            document.getElementById('floatingAlert').appendChild(successAlert);

            setTimeout(function() {
                successAlert.remove();
            }, 2000);
        }

        function toggleComponent(componentID, checked) {

            var stateValue = 0;
            var state = checked ? 1 : 0;

            if ((componentID == "waterPump" || componentID == "growLight") && state == 1) {
                stateValue = 57600;
            } else if (componentID == "purified_water" && state == 1) {
                stateValue = 250;
            } else if ((componentID == "pumpPhUp" || componentID == "pumpPhDown" || componentID == "nutrientA" || componentID == "nutrientB") && state == 1) {
                stateValue = 5;
            } else {
                stateValue = 0
            }

            $.ajax({
                type: "POST",
                url: "update_controls.php",
                data: {
                    componentName: componentID,
                    state: state,
                    dispense_amount: stateValue
                },
                success: function(response) {
                    showAlert(componentID, checked);
                },
                error: function(xhr, status, error) {
                    console.error("Failed to save data: " + error);
                }
            });
        }

        function setInitialSwitchState() {
            <?php foreach ($controlStates as $componentName => $state) : ?>
                //console.log('<?php echo $componentName; ?>', '<?php echo $state ? 'true' : 'false'; ?>');
                var switchBtn = document.getElementById('<?php echo $componentName; ?>');
                if (switchBtn) {
                    switchBtn.checked = <?php echo $state ? 'true' : 'false'; ?>;
                }
            <?php endforeach; ?>
        }

        function SwitchStateUpdate() {
            $.ajax({
                type: "GET",
                url: "get_control_states.php",
                dataType: "json",
                success: function(controlStates) {
                    for (var componentName in controlStates) {
                        var switchBtn = document.getElementById(componentName);
                        if (switchBtn) {
                            var newState = controlStates[componentName] > 0;
                            if (switchBtn.checked !== newState) { // Check if the state has changed
                                switchBtn.checked = newState;
                                // showAlert(componentName, newState); // Show alert for the state change
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Failed to retrieve control states: " + error);
                }
            });
        }

        // Call the function initially
        SwitchStateUpdate();

        // Call the function every (x) second
        setInterval(SwitchStateUpdate, 500);

        function adjustLayout() {
            var screenWidth = window.innerWidth;
            var componentNames = document.querySelectorAll('.component-name');
            var switchBtns = document.querySelectorAll('.switch-btn');

            if (screenWidth <= 768) {
                componentNames.forEach(function(name) {
                    name.style.fontSize = '0.8rem';
                });
                switchBtns.forEach(function(btn) {
                    btn.style.fontSize = '0.8rem';
                });
            } else {
                componentNames.forEach(function(name) {
                    name.style.fontSize = '1rem';
                });
                switchBtns.forEach(function(btn) {
                    btn.style.fontSize = '1rem';
                });
            }
        }

        window.onload = setInitialSwitchState;
        //window.onload = adjustLayout;
        window.onresize = adjustLayout;
    </script>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

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
    <script src="assets/js/main.js"></script>

    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>