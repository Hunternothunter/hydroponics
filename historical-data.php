<?php
require_once('includes/config.php');

session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: loginpage.php");
    exit;
}
$user_id =  $_SESSION['userID'];

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
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="gauge-index.php">Home</a></li>
                    <li class="breadcrumb-item active">Historical Data</li>
                </ol>
            </nav>
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
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <script src="jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <script>
        $(document).ready(function() {
            // Function to fetch and update data for all components
            function fetchAndUpdateData(fromDate, toDate) {
                var components = [{
                        id: 'tdsChart',
                        component: 'tds_level'
                    },
                    {
                        id: 'phChart',
                        component: 'pH_level'
                    },
                    {
                        id: 'ecChart',
                        component: 'ec_level'
                    },
                    {
                        id: 'waterTempChart',
                        component: 'water_temperature'
                    },
                    {
                        id: 'ambientTempChart',
                        component: 'air_temperature'
                    },
                    {
                        id: 'humidityChart',
                        component: 'air_humidity'
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
                            updateChart(response, comp.id);
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ' + status, error);
                        }
                    });
                });
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

        function updateChart(data, chartId) {
            var rows = data.split('<tr>');
            var xValues = [];
            var yValues = [];
            for (var i = 1; i < rows.length; i++) {
                var cols = rows[i].split('<td>');
                if (cols.length >= 2) {
                    var x = cols[2].trim().replace('</td>', '').replace('</tr>', '');
                    var y = cols[1].trim().replace('</td>', '');
                    xValues.push(x);
                    yValues.push(y);
                }
            }

            var ctx = document.getElementById(chartId).getContext('2d');
            var existingChart = Chart.getChart(chartId);
            if (existingChart) {
                existingChart.data.labels = xValues;
                existingChart.data.datasets[0].data = yValues;
                existingChart.update();
            } else {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: xValues,
                        datasets: [{
                            fill: false,
                            pointRadius: 1,
                            borderColor: 'rgba(0,0,255,0.5)',
                            data: yValues
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
    </script>

    <script src="https://cdn3.devexpress.com/jslib/17.1.6/js/dx.all.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
    <script src="js/automatic_logout.js"></script>

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