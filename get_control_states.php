<?php
require_once('includes/config.php');

function getControlStatesFromDatabase($conn) {
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

header('Content-Type: application/json');
echo json_encode($controlStates);
?>