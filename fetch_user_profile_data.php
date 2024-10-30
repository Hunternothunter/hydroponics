<?php
require_once('includes/config.php');

session_start();
$userID = $_SESSION['userID'];
$response = array(); // Initialize response array

try {
    $sql = "SELECT userID, firstname, middlename, lastname, CONCAT(SUBSTRING(firstname, 1, 1), '. ', lastname) fullName, email, profilepic, userPosition, phoneNum, address, profilepic FROM user_login WHERE userID=?";
    $stmt = $conn->prepare($sql);
    $data = array($userID);
    $stmt->execute($data);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $response['fullName'] = $result["firstname"] .' '.$result["lastname"];
        $response['email'] = $result["email"];
        $response['phoneNum'] = $result["phoneNum"];
        $response['address'] = $result["address"];
        $response['userPosition'] = $result["userPosition"];
        $response['profilePicture'] = 'public/profile_pictures/' . $result["profilepic"];
        $response['navFullName'] = $result["fullName"];
    }
} catch (PDOException $e) {
    $response['error'] = "Error: " . $e->getMessage();
}

// Encode the response array to JSON
echo json_encode($response);
?>