<?php
// session_start(); // Start session to access session variables
include("php/query.php"); // Optional if needed for DB connection

// Check if admin is logged in
if (isset($_SESSION['adminEmail'])) {
    unset($_SESSION['adminEmail']);
    unset($_SESSION['adminName']);
    unset($_SESSION['adminId']);
    unset($_SESSION['adminRole']);
}

// Check if user/tester is logged in
if (isset($_SESSION['userEmail'])) {
    unset($_SESSION['userEmail']);
    unset($_SESSION['userName']);
    unset($_SESSION['userId']);
    unset($_SESSION['userRole']);
}

// Optionally destroy the session
// session_destroy();

echo "<script>alert('Logout successful'); location.assign('index.php');</script>";
?>
