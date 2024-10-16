<?php
require_once('includes/config.php');

session_start();
$userID = $_SESSION['userID'];

try {
    $sql = "SELECT profilepic FROM user_login WHERE userID=?";
    $stmt = $conn->prepare($sql);
    $data = array($userID);
    $stmt->execute($data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        header("Content-type: image/jpeg"); // Set appropriate content type
        echo $result["profilepic"];
    }
} catch (PDOException $e) {
    // Handle errors
}
?>