<?php

require_once('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $componentName = $_POST['componentName'];
    // $state = $_POST['state'];
    $dispenseAmount = $_POST['dispense_amount'];

    $sql = "UPDATE components_control SET dispense_amount=? WHERE component_name = ?";
    $stmt = $conn->prepare($sql);
    $data = array($dispenseAmount, $componentName);
    $stmt->execute($data);

    echo "Data saved successfully";
} else {
    echo "Invalid request method";
}
?>