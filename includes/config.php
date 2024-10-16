<?php 

$host = "localhost";
$username = "root";
$password = "";
$database = "capstoneone";


$dsn = "mysql:host={$host};dbname={$database};";

try {
    $conn = new PDO($dsn, $username, $password);
} catch (PDOException $err) {
    echo $err;
}

?>