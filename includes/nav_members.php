<head>
<link rel="stylesheet" href="css/styles.css">
</head>
<?php
// Start session at the beginning of each restricted page

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php'); // Redirect the user to the login page
    exit(); // Stop further execution of the script
}
?>
<nav>
    <p class="tool-bar">
        <a class="active" 
           href="index.php?page=content/home_members.php">
           Home
        </a>
        <br>
        <a href="signout.php"> <!-- Updated link -->
           Sign Out
        </a>
    </p>
</nav>
</header>
