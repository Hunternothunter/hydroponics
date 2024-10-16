<?php
require_once('includes/config.php');

$componentData = [];

try {
    $sql = "SELECT * FROM components_control";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        foreach ($results as $row) {
            // $componentData[$row['component_name']] = $row['control_status'];
            $componentData[$row['component_name']] = $row['dispense_amount'];
        }
        
        $jsonData = json_encode($componentData);

        echo $jsonData;
    } else {
        echo json_encode(["error" => "No data found"]);
    }
} catch (PDOException $err) {
    echo json_encode(["error" => "Error: " . $err->getMessage()]);
}
?>