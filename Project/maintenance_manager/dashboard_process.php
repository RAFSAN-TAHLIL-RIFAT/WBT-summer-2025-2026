<?php
session_start();
require_once "db_connect.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: login.php");
    exit();
}

$manager_name = $_SESSION['name'];

$service_due_query = "SELECT bus_id, bus_number, name, trips_since_service, service_trip_limit 
                      FROM buses 
                      WHERE trips_since_service >= service_trip_limit OR status = 'maintenance'";
$service_due_result = mysqli_query($conn, $service_due_query);

$pending_req_query = "SELECT mr.request_id, b.bus_number, mr.issue, mr.status, mr.created_at 
                      FROM maintenance_requests mr 
                      JOIN buses b ON mr.bus_id = b.bus_id 
                      WHERE mr.status = 'pending' 
                      ORDER BY mr.created_at DESC LIMIT 5";
$pending_req_result = mysqli_query($conn, $pending_req_query);

$low_stock_query = "SELECT part_id, part_name, stock_quantity, unit_price 
                     FROM spare_parts 
                     WHERE stock_quantity < 5 
                     ORDER BY stock_quantity ASC";
$low_stock_result = mysqli_query($conn, $low_stock_query);
?>