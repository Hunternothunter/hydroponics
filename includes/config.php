<?php 

$host = "192.168.0.100";
$username = "hunterg1_huntergram";
$password = "Rafael024!!";
$database = "hunterg1_huntergram";


$dsn = "mysql:host={$host};dbname={$database};";

try {
    $conn = new PDO($dsn, $username, $password);
} catch (PDOException $err) {
    echo $err;
}

?>