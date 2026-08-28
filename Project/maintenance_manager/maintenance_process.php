<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: login.php");
    exit();
}

$manager_id = $_SESSION['user_id'] ?? 1; 
$issueErr = $busErr = $successMsg = "";
$bus_id = $issue = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'create_request') {
    if (empty($_POST["bus_id"])) {
        $busErr = "Please select a bus.";
    } else {
        $bus_id = intval($_POST["bus_id"]);
    }
    if (empty(trim($_POST["issue"]))) {
        $issueErr = "Please describe the issue.";
    } else {
        $issue = trim($_POST["issue"]);
    }
    if (empty($busErr) && empty($issueErr)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO maintenance_requests (bus_id, manager_id, issue, status, created_at) VALUES (?, ?, ?, 'pending', NOW())");
        mysqli_stmt_bind_param($stmt, "iis", $bus_id, $manager_id, $issue);
        
        if (mysqli_stmt_execute($stmt)) {
            $successMsg = "Maintenance request submitted successfully!";
            $bus_id = $issue = ""; 
        } else {
            $issueErr = "Failed to submit request. Please try again.";
        }
        mysqli_stmt_close($stmt);
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'update_status' && isset($_GET['id']) && isset($_GET['status'])) {
    $request_id = intval($_GET['id']);
    $new_status = $_GET['status'];

    $allowed_statuses = ['pending', 'in_progress', 'done', 'cancelled'];
    if (in_array($new_status, $allowed_statuses)) {
        $stmt = mysqli_prepare($conn, "UPDATE maintenance_requests SET status = ? WHERE request_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $new_status, $request_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: maintenance_requests.php");
    exit();
}
$buses_query = "SELECT bus_id, bus_number, name FROM buses ORDER BY bus_number ASC";
$buses_result = mysqli_query($conn, $buses_query);

$requests_query = "SELECT mr.request_id, b.bus_number, b.name AS bus_name, mr.issue, mr.status, mr.created_at 
                  FROM maintenance_requests mr 
                  JOIN buses b ON mr.bus_id = b.bus_id 
                  ORDER BY mr.created_at DESC";
$requests_result = mysqli_query($conn, $requests_query);
?>