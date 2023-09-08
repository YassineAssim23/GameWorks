<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>gameWorks - Welcome</title>
    <link rel="stylesheet" href="content/css/styles.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <?php
    session_start(); // Start the session
    
    if (!isset($_SESSION['userName'])) {
        // User is not logged in, show the public navigation
        include 'includes/nav_public.php';
    } else {
        // User is logged in, show the members navigation
        include 'includes/nav_members.php';
    }
    ?>

    <?php
    // Check if a page parameter is set
    if (isset($_GET['page'])) {
        $requested_page = $_GET['page'];

        switch ($requested_page) {

            // Access Login Page
            case "content/login.php":
                include 'content/login.php';
                break;

            case "content/home_members.php":
                include 'content/home_members.php';
                break;

                case "content/signout.php":
                    include 'content/signout.php';
                    break;


            // Access Register Page
            case "content/register.php":
                include 'content/register.php';
                break;
            
            case "content/craps.php":
                include 'content/craps.php';
                break;

            case "content/rps.php":
                include 'content/rps.php';
                break;

            case "content/tictactoe.php":
                include 'content/tictactoe.php';
                break;

            // Default to home
            default:
                include 'content/home_public.php';
                break; 
        }
    } else {
        // Default to home page if no page parameter is set
        include 'content/home_public.php';
    }
    ?>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
