<?php
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to the login page
    header('Location: index.php?page=content/login.php');
    exit();
}
?>