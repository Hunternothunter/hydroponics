<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: loginpage.php");
    exit;
}

$currentRoute = "dashboard";
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
    <link href="assets/img/logoSIT.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="jquery/dist/jquery.min.js"></script>
</head>
<style>
    .gauge-container {
        width: 100%;
        height: 200px;
        margin: 10px;
        display: inline-block;
        vertical-align: top;
        font-weight: 400;
    }

    .unit-value {
        font-size: 20px;
        margin-top: 10px;
        font-weight: 800;
    }

    .list-container {
        display: flex;
        justify-content: center;
        padding: 10px;
    }

    .list-unstyled {
        padding: 0;
        text-align: left;
        list-style-type: none;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        /* Allow items to wrap to the next line */
        justify-content: center;
    }

    .list-unstyled li {
        margin-right: 20px;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }

    .color-box {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        margin-left: 10px;
        vertical-align: middle;
    }

    .list-unstyled .color-box:first-child {
        padding-right: 50px;
    }

    @media (max-width: 576px) {
        .list-container {
            flex-direction: column;
            align-items: flex-start;
        }

        .list-unstyled {
            flex-direction: column;
            align-items: flex-end;
        }

        .list-unstyled li {
            margin-right: 0;
            margin-bottom: 10px;
            white-space: normal;
        }

        .color-box {
            width: 150px;
        }
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
    }

    .ellipsis-icon {
        margin-right: auto;
        cursor: pointer;
    }

    .card-title {
        flex-grow: 1;
        text-align: center;
        font-size: 15px;
        color: dimgray;
    }
</style>

<body>
    <?php require_once('includes/sidebar.php') ?>
    <?php require_once('includes/navbar.php') ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="gauge-index.php">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="section">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="col-md-12 col-sm-6 col-12 mb-4">
                        <div class="card p-2">
                            <div class="card-body list-container">
                                <ul class="list-unstyled">
                                    <li>Indicators: </li>
                                    <li>Low<span class="color-box" style="background-color: #00BFFF;"></span></li>
                                    <li>Optimal<span class="color-box" style="background-color: #7CFC00;"></span></li>
                                    <li>High<span class="color-box" style="background-color: #FFD700;"></span></li>
                                    <li>Critical<span class="color-box" style="background-color: #FF4500;"></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h5 class="m-3 text-success mb-3">
                        <span class="d-block d-sm-none">This page refreshes every five (5) minutes <span class="text-danger">*</span></span>
                        <span class="d-none d-sm-block">This page refreshes every five (5) minutes <span class="text-danger">*</span></span>
                    </h5>
                </div>

                <div class="d-flex flex-wrap justify-content-center">
                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-header text-center">
                                <a type="button" id="tds-button" class="btn ellipsis-button" data-component="tds_level">
                                    <i class="fa fa-ellipsis-v illipsis-icon"></i>
                                </a>
                                <span class="card-title">Total Dissolved Solids (TDS)</span>
                            </div>
                            <div class="card-body text-center">
                                <div id="tds_gauge" class="gauge-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-header text-center">
                                <a type="button" id="ph-button" class="btn ellipsis-button" data-component="pH_level">
                                    <i class="fa fa-ellipsis-v illipsis-icon"></i>
                                </a>
                                <span class="card-title">pH Level</span>
                            </div>
                            <div class="card-body text-center">
                                <div id="ph_gauge" class="gauge-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-header text-center">
                                <a type="button" id="ec-button" class="btn ellipsis-button" data-component="ec_level">
                                    <i class="fa fa-ellipsis-v illipsis-icon"></i>
                                </a>
                                <span class="card-title">EC Level</span>
                            </div>
                            <div class="card-body text-center">
                                <div id="ec_gauge" class="gauge-container"></div>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-header text-center">
                                <a type="button" id="water-button btn" class="btn ellipsis-button" data-component="water_temperature">
                                    <i class="fa fa-ellipsis-v illipsis-icon"></i>
                                </a>
                                <span class="card-title">Water Temperature</span>
                            </div>
                            <div class="card-body text-center">
                                <div id="water_temp_gauge" class="gauge-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-header text-center">
                                <a type="button" id="temperature-button btn " class="btn ellipsis-button" data-component="air_temperature">
                                    <i class="fa fa-ellipsis-v illipsis-icon"></i>
                                </a>
                                <span class="card-title">Ambient Temperature</span>
                            </div>
                            <div class="card-body text-center">
                                <div id="air_temp_gauge" class="gauge-container"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-12 mb-4">
                        <div class="card">
                            <div class="card-header text-center">
                                <a type="button" id="humidity-button btn" class="btn ellipsis-button" data-component="air_humidity">
                                    <i class="fa fa-ellipsis-v illipsis-icon"></i>
                                </a>
                                <span class="card-title">Relative Humidity</span>
                            </div>
                            <div class="card-body text-center">
                                <div id="humidity_gauge" class="gauge-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
    </main>
    <svg width="0" height="0" version="1.1" class="gradient-mask" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <linearGradient id="gradientGauge">
                <stop class="color-red" offset="0%" />
                <stop class="color-yellow" offset="17%" />
                <stop class="color-green" offset="40%" />
                <stop class="color-yellow" offset="87%" />
                <stop class="color-red" offset="100%" />
            </linearGradient>
        </defs>
    </svg>
    <?php //require_once('includes/controls-history-modal.php'); 
    ?>
    <script src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="js/automatic_logout.js"></script>
    <script>
        $(document).ready(function() {
            $('.ellipsis-button').on('click', function(e) {
                e.preventDefault();

                var componentType = $(this).data('component');
                var componentName = $(this).siblings('.card-title').text();

                // Load the modal content
                $.get('includes/controls-history-modal.php', {
                    component: componentType
                }, function(data) {
                    $('body').append(data);

                    $('#modalTitle').text(componentName + ' Historical Data');

                    // Show the modal
                    $('#controlsHistoryModal').modal('show');

                    // Remove the modal from the DOM after it is hidden
                    $('#controlsHistoryModal').on('hidden.bs.modal', function() {
                        $(this).remove();
                    });
                });
            });
        });


        $(document).ready(function() {
            function createGauge(selector, endValue, unit, ranges) {
                var gauge = $(selector).dxCircularGauge({
                    scale: {
                        startValue: 0,
                        endValue: endValue,
                        // tickInterval: endValue / 10,
                        label: {
                            customizeText: function(arg) {
                                return arg.valueText + ' ' + unit;
                            }
                        }
                    },
                    rangeContainer: {
                        ranges: ranges
                    },
                    valueIndicator: {
                        type: 'needle',
                        color: '#444444'
                    },
                    title: {
                        verticalAlignment: 'bottom',
                        text: '', // Placeholder for the value
                        font: {
                            family: '"Segoe UI", sans-serif',
                            color: '#000',
                            size: 18,
                            font: 'bold'
                        },
                    },
                    subvalues: []
                }).dxCircularGauge("instance");

                // Update title with initial value
                gauge.option("title.text", '0 ' + unit);

                return gauge;
            }

            function updateGauge(gauge, value, unit) {
                gauge.value(value);
                gauge.option("title.text", value + ' ' + unit);
            }

            function fetchSensorData() {
                $.ajax({
                    type: "GET",
                    url: "long_polling.php",
                    dataType: "json",
                    success: function(data) {
                        updateGauge(tdsGauge, parseFloat(data.tds_level), 'ppm');
                        updateGauge(phGauge, parseFloat(data.pH_level), 'pH');
                        updateGauge(ecGauge, parseFloat(data.ec_level), 'µS/cm');
                        updateGauge(waterTempGauge, parseFloat(data.water_temperature), '°C');
                        updateGauge(airTempGauge, parseFloat(data.air_temperature), '°C');
                        updateGauge(humidityGauge, parseFloat(data.air_humidity), '%');

                        setTimeout(fetchSensorData, 240000); // 4 minutes
                    },
                    error: function(xhr, status, error) {
                        console.error("Failed to fetch sensor data: " + error);
                        setTimeout(fetchSensorData, 5000); // Retry after 5 seconds
                    }
                });
            }

            // Define the color ranges for each gauge
            const tdsRanges = [{
                    startValue: 0,
                    endValue: 550,
                    color: "#00BFFF"
                },
                {
                    startValue: 556,
                    endValue: 850,
                    color: "#7CFC00"
                },
                {
                    startValue: 851,
                    endValue: 1000,
                    color: "#FFD700"
                },
                {
                    startValue: 1001,
                    endValue: 1200,
                    color: "#FF4500"
                }
            ];

            const phRanges = [{
                    startValue: 0,
                    endValue: 5.4,
                    color: "#FF4500"
                },
                {
                    startValue: 5.5,
                    endValue: 6.6,
                    color: "#7CFC00"
                },
                {
                    startValue: 6.5,
                    endValue: 8,
                    color: "#FFD700"
                },
                {
                    startValue: 8,
                    endValue: 10,
                    color: "#FF4500"
                }
            ];

            const ecRanges = [{
                    startValue: 0,
                    endValue: 3,
                    color: "#7CFC00"
                },
                {
                    startValue: 3,
                    endValue: 4,
                    color: "#FFD700"
                },
                {
                    startValue: 4,
                    endValue: 5,
                    color: "#FF4500"
                }
            ];

            const waterTempRanges = [{
                    startValue: 0,
                    endValue: 10,
                    color: "#00BFFF"
                },
                {
                    startValue: 10,
                    endValue: 25,
                    color: "#7CFC00"
                },
                {
                    startValue: 25,
                    endValue: 35,
                    color: "#FFD700"
                },
                {
                    startValue: 35,
                    endValue: 50,
                    color: "#FF4500"
                }
            ];

            const airTempRanges = [{
                    startValue: 0,
                    endValue: 15,
                    color: "#00BFFF"
                },
                {
                    startValue: 15,
                    endValue: 25,
                    color: "#7CFC00"
                },
                {
                    startValue: 25,
                    endValue: 35,
                    color: "#FFD700"
                },
                {
                    startValue: 35,
                    endValue: 50,
                    color: "#FF4500"
                }
            ];

            const humidityRanges = [{
                    startValue: 0,
                    endValue: 30,
                    color: "#FF4500"
                },
                {
                    startValue: 30,
                    endValue: 60,
                    color: "#7CFC00"
                },
                {
                    startValue: 60,
                    endValue: 80,
                    color: "#FFD700"
                },
                {
                    startValue: 80,
                    endValue: 100,
                    color: "#FF4500"
                }
            ];

            // Create gauges with the defined ranges
            var tdsGauge = createGauge('#tds_gauge', 1200, 'ppm', tdsRanges);
            var phGauge = createGauge('#ph_gauge', 10, 'pH', phRanges);
            var ecGauge = createGauge('#ec_gauge', 5, 'µS/cm', ecRanges);
            var waterTempGauge = createGauge('#water_temp_gauge', 50, '°C', waterTempRanges);
            var airTempGauge = createGauge('#air_temp_gauge', 50, '°C', airTempRanges);
            var humidityGauge = createGauge('#humidity_gauge', 100, '%', humidityRanges);

            fetchSensorData();
        });
    </script>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>