<?php
require_once('includes/config.php');

// Set the maximum execution time to infinity to prevent the script from timing out
set_time_limit(0);

// Function to fetch the latest sensor data
function fetchSensorData()
{
    global $conn;

    try {
        // Prepare the SQL statement to fetch the latest sensor data from the database
        $sql = "SELECT pH_level, tds_level, water_temperature, air_temperature, air_humidity, ec_level, timestamp FROM hydro_parameters ORDER BY id DESC LIMIT 1";
        $stmt = $conn->prepare($sql);

        // Execute the statement
        $stmt->execute();

        // Fetch the result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    } catch (PDOException $e) {
        // Handle errors
        return false;
    }
}

// Loop continuously to check for updates
while (true) {
    // Fetch the latest sensor data
    $latestData = fetchSensorData();

    // Check if there's new data available
    if ($latestData) {
        // Output the data as JSON
        echo json_encode($latestData);

        // Flush the output buffer to send the response immediately
        flush();
        break;
    }

    // Wait for a short interval before checking again (e.g., 1 second)
    sleep(1);
}