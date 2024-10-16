<?php
require_once('includes/config.php');

try {
    $sql = "SELECT * FROM controls";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        $componentData = $results['pumpPhDown'] .', ' . $results['pumpPhUp'].', ' . $results['purified_water'].', ' . $results['waterPump'].', '. $results['growLight'];
        echo $componentData;
    } else {
        echo "No data found";
    }
} catch (PDOException $err) {
    echo $err->getMessage();
}
?>