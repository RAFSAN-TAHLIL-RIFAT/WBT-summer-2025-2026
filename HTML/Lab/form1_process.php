<?php
require_once "db.php";

$nameErr = $phoneErr = $dobErr = $emailErr = $passwordErr = $updatesErr = $termsErr = "";
$dbErr = "";
$name = $phone = $dob = $email = "";
$updates = $terms = 0;

$isValid = false;

function cleanInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* ---------- Full Name: required, letters and spaces only ---------- */
    if (empty($_POST["name"])) {
        $nameErr = "Enter your full name";
    } else {
        $name = cleanInput($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]+$/", $name)) {
            $nameErr = "Use letters, spaces, hyphens and apostrophes only";
        } elseif (strlen($name) < 3) {
            $nameErr = "Name must be at least 3 characters";
        }
    }

    /* ---------- Phone Number: required, 10 digits ---------- */
    if (empty($_POST["phone"])) {
        $phoneErr = "Enter your phone number";
    } else {
        $phone = cleanInput($_POST["phone"]);
        if (!preg_match("/^[0-9]{10}$/", $phone)) {
            $phoneErr = "Phone number must be 10 digits";
        }
    }

    /* ---------- Date of Birth: required, real date, past, age 18+ ---------- */
    if (empty($_POST["dob"])) {
        $dobErr = "Enter your date of birth";
    } else {
        $dob   = cleanInput($_POST["dob"]);
        $today = new DateTime();
        $birth = DateTime::createFromFormat("Y-m-d", $dob);

        if (!$birth || $birth->format("Y-m-d") !== $dob) {
            $dobErr = "Enter a valid date in YYYY-MM-DD format";
        } elseif ($birth > $today) {
            $dobErr = "Date of birth cannot be in the future";
        } elseif ($birth->diff($today)->y < 18) {
            $dobErr = "You must be at least 18 years old to register";
        }
    }

    /* ---------- Email: required, valid format ---------- */
    if (empty($_POST["email"])) {
        $emailErr = "Enter your email address";
    } else {
        $email = cleanInput($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Enter a valid email address, e.g. jane@company.com";
        }
    }

    /* ---------- Password: required, 8+ chars, letter + number ----------
       Not cleaned and never sent back to the browser.               */
    if (empty($_POST["password"])) {
        $passwordErr = "Enter a password";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters";
        } elseif (!preg_match("/[A-Za-z]/", $password) ||
                  !preg_match("/[0-9]/", $password)) {
            $passwordErr = "Password must contain at least one letter and one number";
        }
    }

    /* ---------- Checkboxes Processing ---------- */
    $updates = isset($_POST["updates"]) ? 1 : 0;

    if (empty($_POST["terms"])) {
        $termsErr = "You must agree to the Terms & Privacy Policy";
    } else {
        $terms = 1;
    }

    $isValid = !$nameErr && !$phoneErr && !$dobErr
            && !$emailErr && !$passwordErr && !$termsErr;

    /* ---------- Save to database ---------- */
    if ($isValid) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO form1 (name, phone, dob, email, password, updates, terms)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        mysqli_stmt_bind_param(
            $stmt, "sssssii",
            $name, $phone, $dob, $email, $passwordHash, $updates, $terms
        );

        if (!mysqli_stmt_execute($stmt)) {
            $dbErr = "Could not save registration: " . mysqli_stmt_error($stmt);
            $isValid = false;
        }
        mysqli_stmt_close($stmt);
    }
}