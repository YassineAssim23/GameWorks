<head>
<link rel="stylesheet" href="css/styles.css">
</head>
<?php 
/*
File name: nav_public.php
Author: Yassine Assim
Date created: Summer 2023
Date modified: Summer 2023
Version: 23.0
Copyright: 
    This work is the intellectual property of Sheridan College. 
    Any further copying and distribution outside of class must be within 
    the copyright law. Posting to commercial sites for profit is prohibited.
Purpose: learn programming server-side functionality using PHP to provide
         access to a database to register and login users
Description:
    navigation component accessible to the general public (everyone)
    The $members variable is NOT set since the user has not logged in (yet)
*/
?>
<nav>
    <p class="tool-bar">
        <a class="active" 
           href="index.php?page=content/home_public.php">
           Home
        </a>
        <a href="index.php?page=content/login.php">
           Login
        </a>
        <a href="index.php?page=content/register.php">
           Register
        </a>
    </p>
</nav>
</header>
