<?php
require_once('includes/config.php');

// Assuming POST method is used
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_login WHERE (username=? AND password=?) AND isActive=1";
    $stmt = $conn->prepare($sql);
    $data = array($username, $password);
    $stmt->execute($data);
    $user = $stmt->fetch();

    if ($stmt->rowCount() > 0) {
        session_start();
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['profilepic'] = $user['profilepic'];
        $_SESSION['userFirstName'] = $user['firstname'];
        $_SESSION['userLastName'] = $user['lastname'];

        // header('location:gauge-index.php');
        echo json_encode(array('success' => true));
        exit;
    } else {
        echo json_encode(array('success' => false));
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Method Not Allowed'));
    exit;
}
?>