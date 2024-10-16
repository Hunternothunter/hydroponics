<?php
require_once('includes/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['img'])) {
    // Retrieve the userID from the session
    $id = $_SESSION['userID'];
    $firstname = $_POST['fullName'];
    $lastname = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phone'];
    $address = $_POST['address'];
    $userPosition = $_POST['userPosition'];
    $file = $_FILES['img'];

    if ($id != 0) {
        // Update user details
        $sql = "UPDATE user_login SET firstname=?, lastname=?, email=?, phoneNum=?, address=?, userPosition=? WHERE userID=?";
        $data = array($firstname, $lastname, $email, $phoneNum, $address, $userPosition, $id);
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);

        // Handle file upload
        if ($file['error'] == UPLOAD_ERR_OK) {
            // Get file content
            $imgData = file_get_contents($file['tmp_name']);
            // Update profile picture blob in the database
            $sql = "UPDATE user_login SET profilepic=? WHERE userID=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($imgData, $id));
        } else {
            echo "Error: File upload failed.";
            echo '<script>alert("Error: File upload failed")</script>';
        }

        header("Location: users-profile.php");
        exit();
    }
}
