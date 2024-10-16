<?php

require_once('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the component name sent from the client
    $componentName = $_POST['componentName'];

    // Fetch control status from the database based on the component name
    $sql = "SELECT control_status FROM components_control WHERE component_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$componentName]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Prepare response data as an associative array
    $response = array('controlStatus' => $row['control_status']);

    // Send control status back to the client as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    echo "Invalid request method";
}
?>