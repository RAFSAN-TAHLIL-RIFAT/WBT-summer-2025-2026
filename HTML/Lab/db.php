<?php
$host = "localhost";
$user = "root";
$pass = "";

$conn = mysqli_connect($host, $user, $pass);
if(!$conn){
    die("Connection failed: ". mysqli_connect_error());
}
echo "Connected Successfully";

$conn = mysqli_connect($host, $user, $pass, "school_wbt_DB");
if(!$conn){
    die("Connection failed: ". mysqli_connect_error());
}
?>