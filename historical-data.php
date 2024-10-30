<?php
require_once('includes/config.php');

session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['userID'];

$currentRoute = "historical";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Historical Data</title>
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
    <style>
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .card-title {
            flex-grow: 1;
            text-align: center;
            font-size: 15px;
            color: dimgray;
        }
    </style>
</head>

<body>
    <?php require_once('includes/navbar.php'); ?>
    <?php require_once('includes/sidebar.php'); ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Historical Data</h1>
        </div>
        <section class="section">
            <div class="container">
            </div>
            <div class="row">
                <div class="col col-md-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <h5 class="mt-3">Choose:</h5>
                            <div class="row m-3">
                                <div class="col col-md-6">
                                    From: <input type="date" class="form-control" name="dtpFrom">
                                </div>
                                <div class="col col-md-6">
                                    To: <input type="date" class="form-control" name="dtpTo">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col col-md-6"></div>
                                <div class="col col-md-6">
                                    <div class="row">
                                        <div class="col col-md-6"></div>
                                        <div class="col col-md-6 text-right">
                                            <input type="button" class="btn btn-success" style="width: 100%;" value="Generate data" name="btnGenerate"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="card-title">Total Dissolved Solids (TDS)</span>
                        </div>
                        <div class="card-body text-center">
                            <canvas id="tdsChart" style="width:100%;max-width:600px"></canvas>
                            <div id="tds_gauge" class="gauge-container"></div>
                            <div id="tds_status" class="mt-2"></div> <!-- Status Display -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="card-title">pH Level</span>
                        </div>
                        <div class="card-body text-center">
                            <canvas id="phChart" style="width:100%;max-width:600px"></canvas>
                            <div id="ph_gauge" class="gauge-container"></div>
                            <div id="ph_status" class="mt-2"></div> <!-- Status Display -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="card-title">EC Level</span>
                        </div>
                        <div class="card-body text-center">
                            <canvas id="ecChart" style="width:100%;max-width:600px"></canvas>
                            <div id="ec_gauge" class="gauge-container"></div>
                            <div id="ec_status" class="mt-2"></div> <!-- Status Display -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="card-title">Water Temperature</span>
                        </div>
                        <div class="card-body text-center">
                            <canvas id="waterTempChart" style="width:100%;max-width:600px"></canvas>
                            <div id="water_temp_gauge" class="gauge-container"></div>
                            <div id="water_temp_status" class="mt-2"></div> <!-- Status Display -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="card-title">Ambient Temperature</span>
                        </div>
                        <div class="card-body text-center">
                            <canvas id="ambientTempChart" style="width:100%;max-width:600px"></canvas>
                            <div id="air_temp_gauge" class="gauge-container"></div>
                            <div id="air_temp_status" class="mt-2"></div> <!-- Status Display -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <span class="card-title">Relative Humidity</span>
                        </div>
                        <div class="card-body text-center">
                            <canvas id="humidityChart" style="width:100%;"></canvas>
                            <div id="humidity_gauge" class="gauge-container"></div>
                            <div id="humidity_status" class="mt-2"></div> <!-- Status Display -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php require_once('includes/mobile-nav.php'); ?>

    <script src="jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <script>
        $(document).ready(function() {
            // Function to fetch and update data for all components
            function fetchAndUpdateData(fromDate, toDate) {
                var components = [{
                        id: 'tdsChart',
                        component: 'tds_level',
                        statusElement: 'tds_status'
                    },
                    {
                        id: 'phChart',
                        component: 'pH_level',
                        statusElement: 'ph_status'
                    },
                    {
                        id: 'ecChart',
                        component: 'ec_level',
                        statusElement: 'ec_status'
                    },
                    {
                        id: 'waterTempChart',
                        component: 'water_temperature',
                        statusElement: 'water_temp_status'
                    },
                    {
                        id: 'ambientTempChart',
                        component: 'air_temperature',
                        statusElement: 'air_temp_status'
                    },
                    {
                        id: 'humidityChart',
                        component: 'air_humidity',
                        statusElement: 'humidity_status'
                    }
                ];

                components.forEach(function(comp) {
                    $.ajax({
                        url: 'includes/fetch_data.php',
                        type: 'GET',
                        data: {
                            component: comp.component,
                            from_date: fromDate,
                            to_date: toDate
                        },
                        success: function(response) {
                            var { chartData, statusMessage } = processResponse(response);
                            updateChart(chartData, comp.id);
                            updateStatus(comp.statusElement, statusMessage);
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ' + status, error);
                        }
                    });
                });
            }

            function processResponse(response) {
                var rows = response.split('<tr>');
                var xValues = [];
                var yValues = [];
                var maxValue = Number.MIN_VALUE;
                var minValue = Number.MAX_VALUE;

                for (var i = 1; i < rows.length; i++) {
                    var cols = rows[i].split('<td>');
                    if (cols.length >= 2) {
                        var x = cols[2].trim().replace('</td>', '').replace('</tr>', '');
                        var y = parseFloat(cols[1].trim().replace('</td>', ''));
                        xValues.push(x);
                        yValues.push(y);
                        if (y > maxValue) maxValue = y;
                        if (y < minValue) minValue = y;
                    }
                }

                // Generate a status message based on the range of values
                var statusMessage = generateStatusMessage(minValue, maxValue);

                return {
                    chartData: {
                        labels: xValues,
                        data: yValues
                    },
                    statusMessage: statusMessage
                };
            }

            function generateStatusMessage(min, max) {
                // Customize the logic based on your specific requirements
                if (min < 0 || max > 100) {
                    return 'Warning: Values are outside the safe range!';
                } else if (min >= 0 && max <= 50) {
                    return 'Status: Optimal conditions.';
                } else {
                    return 'Status: Monitor closely.';
                }
            }

            function updateChart(chartData, chartId) {
                var ctx = document.getElementById(chartId).getContext('2d');
                var existingChart = Chart.getChart(chartId);
                if (existingChart) {
                    existingChart.data.labels = chartData.labels;
                    existingChart.data.datasets[0].data = chartData.data;
                    existingChart.update();
                } else {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartData.labels,
                            datasets: [{
                                fill: false,
                                pointRadius: 1,
                                borderColor: 'rgba(0,0,255,0.5)',
                                data: chartData.data
                            }]
                        },
                        options: {
                            plugins: {
                                legend: {
                                    display: false
                                },
                                title: {
                                    display: true,
                                    fontSize: 24
                                }
                            },
                            scales: {
                                x: {
                                    display: false
                                },
                                y: {
                                    ticks: {
                                        fontSize: 14
                                    }
                                }
                            }
                        }
                    });
                }
            }

            function updateStatus(statusElementId, message) {
                $('#' + statusElementId).text(message);
            }

            var currentDate = new Date();
            var fromDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            var toDate = currentDate;

            var formattedFromDate = fromDate.toISOString().slice(0, 10);
            var formattedToDate = toDate.toISOString().slice(0, 10);

            $('input[type="date"]').eq(0).val(formattedFromDate);
            $('input[type="date"]').eq(1).val(formattedToDate);
            fetchAndUpdateData(formattedFromDate, formattedToDate);

            $('input[value="Generate data"]').on('click', function() {
                fromDate = $('input[type="date"]').eq(0).val();
                toDate = $('input[type="date"]').eq(1).val();
                fetchAndUpdateData(fromDate, toDate);
            });
        });
    </script>

    <script src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script>
    <!-- <script src="js/automatic_logout.js"></script> -->

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
