<?php
$host = "localhost";
$user = "root";
$password = ""; 
$dbname = "bus_management_system";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
else {
    //echo "Database Connected Successfully";
}
?>