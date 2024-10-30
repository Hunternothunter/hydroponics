<?php
require_once('includes/config.php');
session_start();

header('Content-Type: application/json'); // Set header to return JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            $uploadDir = 'public/profile_pictures/'; // Directory for storing profile pictures
            $fileName = basename($file['name']);
            $targetFilePath = $uploadDir . $fileName;

            // Move the uploaded file to the server
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                // Update profile picture filename in the database
                $sql = "UPDATE user_login SET profilepic=? WHERE userID=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute(array($fileName, $id));
            } else {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Error: File upload failed.']);
                exit();
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Personal information has been updated.']);
        exit();
    }
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'User ID not found.']);
} else {
    http_response_code(405); // Method not allowed
    echo json_encode([ 'status' => 'error', 'message' => 'Method not allowed.']);
}
?>
