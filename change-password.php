<?php
require_once('includes/config.php');
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['userID']; // Ensure this session variable is set
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $renewPassword = $_POST['renewPassword'];

    // Validate passwords
    if ($newPassword !== $renewPassword) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'New passwords do not match.']);
        exit();
    }

    // Fetch current password from the database
    $sql = "SELECT password FROM user_login WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    // Check if the current password matches
    if ($user && $currentPassword === $user['password']) {
        // Update password in the database
        $sql = "UPDATE user_login SET password = ? WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$newPassword, $userId]);

        echo json_encode(['status' => 'success', 'message' => 'Password successfully changed.']);
    } else {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
    }

    // Remove the redirect header
    // header("Location: users-profile.php"); // Remove this line
    exit();
} else {
    http_response_code(405); // Method not allowed
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}
?>