<?php
session_start();
require_once "db_connect.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    header("Location: login.php");
    exit();
}

$partNameErr = $stockErr = $priceErr = $successMsg = "";
$part_name = $stock_quantity = $unit_price = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'create_part') {
    if (empty(trim($_POST["part_name"]))) {
        $partNameErr = "Please enter part name.";
    } else {
        $part_name = trim($_POST["part_name"]);
    }

    if (!isset($_POST["stock_quantity"]) || $_POST["stock_quantity"] === '') {
        $stockErr = "Please enter stock quantity.";
    } elseif (!is_numeric($_POST["stock_quantity"]) || intval($_POST["stock_quantity"]) < 0) {
        $stockErr = "Stock quantity must be a non-negative number.";
    } else {
        $stock_quantity = intval($_POST["stock_quantity"]);
    }

    if (empty($_POST["unit_price"])) {
        $priceErr = "Please enter unit price.";
    } elseif (!is_numeric($_POST["unit_price"]) || floatval($_POST["unit_price"]) < 0) {
        $priceErr = "Price must be a valid positive number.";
    } else {
        $unit_price = floatval($_POST["unit_price"]);
    }

    if (empty($partNameErr) && empty($stockErr) && empty($priceErr)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO spare_parts (part_name, stock_quantity, unit_price, updated_at) VALUES (?, ?, ?, NOW())");
        mysqli_stmt_bind_param($stmt, "sid", $part_name, $stock_quantity, $unit_price);
        
        if (mysqli_stmt_execute($stmt)) {
            $successMsg = "Spare part added successfully!";
            $part_name = $stock_quantity = $unit_price = "";
        } else {
            $partNameErr = "Failed to add spare part. Try again.";
        }
        mysqli_stmt_close($stmt);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'update_stock') {
    $part_id = intval($_POST['part_id']);
    $new_stock = intval($_POST['new_stock']);

    if ($part_id > 0 && $new_stock >= 0) {
        $stmt = mysqli_prepare($conn, "UPDATE spare_parts SET stock_quantity = ?, updated_at = NOW() WHERE part_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $new_stock, $part_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: spare_parts.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $part_id = intval($_GET['id']);
    
    if ($part_id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM spare_parts WHERE part_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $part_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    header("Location: spare_parts.php");
    exit();
}

$parts_query = "SELECT part_id, part_name, stock_quantity, unit_price, updated_at FROM spare_parts ORDER BY part_id DESC";
$parts_result = mysqli_query($conn, $parts_query);
?>