<?php
session_start(); // Start the session

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or wherever you want after sign-out
header('Location: index.php');
exit();
?>
