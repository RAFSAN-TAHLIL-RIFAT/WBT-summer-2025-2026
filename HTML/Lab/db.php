<?php
/* ---------- Database connection settings ---------- */
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "portfolio_db";

/* ---------- Connect (MySQLi, procedural) ---------- */
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
