<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<style>
    th,
    td {
        text-align: center;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="controlsHistoryModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Component History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <h5>Filter:</h5>
                        <div class="row m-3">
                            <div class="col col-md-6">
                                <label for="dtpFrom">From: </label>
                                <input type="date" class="form-control" name="dtpFrom">
                            </div>
                            <div class="col col-md-6">
                                <label for="dtpTo">To: </label>
                                <input type="date" class="form-control" name="dtpTo">
                            </div>
                            <div class="col col-md-12 mt-3">
                                <input type="button" class="btn btn-success" style="width: 100%;" name="btnGenerate" value="Generate data">
                            </div>
                        </div>
                    </div>
                    <div class="card-title">
                        <div class="row mt-3">
                            <div class="col col-md-12">
                                <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatablesSimple" class="table">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Date and Time</th>
                                </tr>
                            </thead>
                            <tbody id="modalTableBody">
                                <!--  the data will be placed here  -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Level</th>
                                    <th>Date and Time</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('input[name="btnGenerate"]').on('click', function() {
            var fromDate = $('input[name="dtpFrom"]').val();
            var toDate = $('input[name="dtpTo"]').val();
            var component = '<?php echo isset($_GET['component']) ? $_GET['component'] : $_GET['component']; ?>';

            $.ajax({
                url: 'includes/fetch_data.php', // PHP script to handle data fetching
                type: 'GET',
                data: {
                    component: component,
                    from_date: fromDate,
                    to_date: toDate
                },
                success: function(response) {
                    $('#modalTableBody').html(response);
                    updateChart(response); // Call function to update chart
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status, error);
                }
            });
        });
    });

    var chart = null; // Declare a global variable to hold the chart object

    function updateChart(data) {
        // Parse the response and extract x and y values
        var rows = data.split('<tr>');
        var xValues = [];
        var yValues = [];
        for (var i = 1; i < rows.length; i++) { // Start from index 1 to skip the first empty row
            var cols = rows[i].split('<td>');
            if (cols.length >= 3) { // Ensure there are enough columns
                // Extract x (timestamp) and y (component level) values and remove '</td>' if present
                var x = cols[2].trim().replace('</td>', '').replace('</tr>', ''); // Assuming timestamp is in the third column
                var y = cols[1].trim().replace('</td>', ''); // Assuming component level is in the second column

                // Convert x-value (timestamp) to a more readable format if needed
                // For example, you can use moment.js library for date formatting

                xValues.push(x); // Push timestamp to xValues
                yValues.push(y); // Push component level to yValues
            }
        }

        if (chart) {
            // If chart already exists, update its data
            chart.data.labels = xValues;
            chart.data.datasets[0].data = yValues;
            chart.update();
        } else {
            // If chart doesn't exist, create a new one
            chart = new Chart("myChart", {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        fill: false,
                        pointRadius: 1,
                        borderColor: "rgba(0,0,255,0.5)",
                        data: yValues
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        // text: "y = sin(x)",
                        fontSize: 24
                    },
                    scales: {
                        xAxes: [{
                            display: false // Hide x-axis labels
                        }],
                        yAxes: [{
                            ticks: {
                                fontSize: 14 // Adjust the font size of y-axis ticks
                            }
                        }]
                    }
                }
            });
        }
    }

    function closeModal() {
        $('#controlsHistoryModal').modal('hide');
    }
</script>