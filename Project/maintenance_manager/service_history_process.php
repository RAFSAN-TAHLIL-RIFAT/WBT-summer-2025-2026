<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: login.php");
    exit();
}

$manager_id = $_SESSION['user_id'] ?? 1; 
$busErr = $serviceTypeErr = $costErr = $successMsg = "";
$bus_id = $service_type = $cost = $part_id = $part_quantity = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'record_service') {
    if (empty($_POST["bus_id"])) {
        $busErr = "Please select a bus.";
    } else {
        $bus_id = intval($_POST["bus_id"]);
    }

    if (empty(trim($_POST["service_type"]))) {
        $serviceTypeErr = "Please enter service details.";
    } else {
        $service_type = trim($_POST["service_type"]);
    }

    if (empty($_POST["cost"]) || !is_numeric($_POST["cost"]) || floatval($_POST["cost"]) < 0) {
        $costErr = "Please enter a valid cost.";
    } else {
        $cost = floatval($_POST["cost"]);
    }

    $part_id = !empty($_POST["part_id"]) ? intval($_POST["part_id"]) : null;
    $part_quantity = !empty($_POST["part_quantity"]) ? intval($_POST["part_quantity"]) : 0;

    if (empty($busErr) && empty($serviceTypeErr) && empty($costErr)) {
        mysqli_begin_transaction($conn);

        try {
            $stmt = mysqli_prepare($conn, "INSERT INTO service_history (bus_id, manager_id, work_done, cost, service_date, created_at) VALUES (?, ?, ?, ?, CURDATE(), NOW())");
            mysqli_stmt_bind_param($stmt, "iisd", $bus_id, $manager_id, $service_type, $cost);
            mysqli_stmt_execute($stmt);
            $service_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);

            $stmt_bus = mysqli_prepare($conn, "UPDATE buses SET trips_since_service = 0, status = 'active' WHERE bus_id = ?");
            mysqli_stmt_bind_param($stmt_bus, "i", $bus_id);
            mysqli_stmt_execute($stmt_bus);
            mysqli_stmt_close($stmt_bus);

            if ($part_id > 0 && $part_quantity > 0) {
                $stmt_part = mysqli_prepare($conn, "UPDATE spare_parts SET stock_quantity = GREATEST(0, stock_quantity - ?), updated_at = NOW() WHERE part_id = ?");
                mysqli_stmt_bind_param($stmt_part, "ii", $part_quantity, $part_id);
                mysqli_stmt_execute($stmt_part);
                mysqli_stmt_close($stmt_part);
            }

            mysqli_commit($conn);
            $successMsg = "Service record saved successfully!";
            $bus_id = $service_type = $cost = $part_id = $part_quantity = "";

        } catch (Exception $e) {
            mysqli_rollback($conn);
            $serviceTypeErr = "Transaction failed: " . $e->getMessage();
        }
    }
}

$buses_result = mysqli_query($conn, "SELECT bus_id, bus_number, name FROM buses ORDER BY bus_number ASC");

$parts_result = mysqli_query($conn, "SELECT part_id, part_name, stock_quantity FROM spare_parts WHERE stock_quantity > 0 ORDER BY part_name ASC");

$history_query = "SELECT sh.service_id, b.bus_number, b.name AS bus_name, sh.work_done AS service_type, sh.cost, sh.service_date 
                 FROM service_history sh 
                 JOIN buses b ON sh.bus_id = b.bus_id 
                 ORDER BY sh.service_id DESC";
$history_result = mysqli_query($conn, $history_query);
?>