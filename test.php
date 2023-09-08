<?php
session_start(); // Start the session
if (isset($_SESSION['username'])) {
    
    include 'content/home_members.php';
    exit();
}
else{
    include 'content/login.php';
}
?>
<p>test page</p>