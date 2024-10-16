<?php
require_once("config.php");

// Get the parameters from the AJAX request
$component = isset($_GET['component']) ? $_GET['component'] : 'pH_level';
$fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : null;
$toDate = isset($_GET['to_date']) ? $_GET['to_date'] : null;

$componentsMap = [
    'pH_level' => 'pH Level',
    'tds_level' => 'Total Dissolved Solids (TDS)',
    'ec_level' => 'EC Level',
    'water_temperature' => 'Water Temperature',
    'air_temperature' => 'Ambient Temperature',
    'air_humidity' => 'Relative Humidity'
];

if (!array_key_exists($component, $componentsMap)) {
    echo "<tr><td colspan='2'>Invalid component</td></tr>";
    exit;
}

// SQL query to fetch data
$sql = "SELECT $component AS level, timestamp FROM hydro_parameters";

// Check if date filters are provided
if ($fromDate && $toDate) {
    // Ensure the dates are in a valid format and properly escaped
    $fromDate = date('Y-m-d', strtotime($fromDate));
    $toDate = date('Y-m-d', strtotime($toDate));

    // Update the SQL query to filter by date range
    $sql .= " WHERE DATE(timestamp) BETWEEN '$fromDate' AND '$toDate'";
}else {
    echo "<tr><td colspan='2' style='color:crimson;'>Both date fields are required.</td></tr>";
    exit;
}

$stmt = $conn->prepare($sql);
$stmt->execute();

$str = "";
// $data = array();

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $str .= "<tr><td>{$row['level']}</td>";
        $str .= "<td>{$row['timestamp']}</td></tr>";
    }
    // $data[] = $row;
} else {
    $str .= "<tr><td colspan='2'>No records found</td></tr>";
    // echo json_encode(array('message' => 'No records found'));
}


echo $str;
?>