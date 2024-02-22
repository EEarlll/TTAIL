<?php
if (!isset($_SESSION)) {
    session_start();
}

// Access session variables
if (isset($_SESSION['username'])) {
    $user_name = $_SESSION['username'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit;
}