<?php
require_once('includes/config.php');

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $tds_level = $_POST['tds_level'];
    $pH_level = $_POST['pH_level'];
    $water_level = $_POST['water_temperature'];
    $air_temperature = $_POST['air_temperature'];
    $air_humidity = $_POST['air_humidity'];
    $ec_level = $_POST['ec_level'];
    
    try {
        $sql = "INSERT INTO hydro_parameters(tds_level, pH_level, water_temperature, air_temperature, air_humidity, ec_level) VALUES(?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $values = array($tds_level, $pH_level, $water_level, $air_temperature, $air_humidity, $ec_level);
        $stmt->execute($values);

        if($stmt->rowCount() > 0){
            echo "<script>alert('Data inserted successfully');</script>";
        } else {
            echo "<script>alert('Failed to insert data');</script>";
        }

    } catch (PDOException $err) {
        echo "<script>alert('".$err->getMessage()."');</script>";
    }
}
?>
