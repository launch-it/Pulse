<?php
session_start(); // Start the session

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page or home page after logging out
header("Location: /app/login.php"); // Adjust the path as necessary
exit();
