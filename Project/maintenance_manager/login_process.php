<?php
session_start();
require_once "db_connect.php";

$emailErr = $passwordErr = $dbErr = $authErr = "";
$email = "";
$remember = 0;

$isValid = false;

function cleanInput($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}
if (isset($_SESSION['role']) && $_SESSION['role'] === 'manager') {
    header("Location: dashboard.php");
    exit();
} elseif (isset($_COOKIE['user_email'])) {
    $cookie_email = cleanInput($_COOKIE['user_email']);
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? AND role = 'manager' LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $cookie_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = $row['role'];
        header("Location: dashboard.php");
        exit();
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Enter your email address";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Enter a valid email address";
        }
    }
    if (empty($_POST["password"])) {
        $passwordErr = "Enter your password";
    } else {
        $password = $_POST["password"];
    }
    $remember = isset($_POST["remember"]) ? 1 : 0;

    $isValid = !$emailErr && !$passwordErr;
    if ($isValid) {
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $email);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result)) {
                if ($password === $user['password']) {
                    if ($user['role'] === 'manager') {
                        $_SESSION['user_id'] = $user['user_id'];
                        $_SESSION['name'] = $user['name'];
                        $_SESSION['role'] = $user['role'];

                        if ($remember === 1) {
                            setcookie("user_email", $user['email'], time() + 5, "/");
                        }

                        header("Location: dashboard.php");
                        exit();
                    } else {
                        $dbErr = "Access denied: You are not authorized as a Manager";
                    }
                } else {
                    $passwordErr = "Incorrect password";
                }
            } else {
                $emailErr = "No account found with this email";
            }
        } else {
            $dbErr = "Database query failed: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
}
?>