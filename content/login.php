<!-- Opening form tag: The form allows users to input data and send it to the server -->
<head>
<link rel="stylesheet" href="css/styles.css">
</head>
<form action="#" method="post">
    <h2>Login</h2>
    <!-- Label and input field for username: User provides their username -->
    <label for="loginUsername">Username:</label>
    <input type="text" id="loginUsername" name="loginUsername" required><br>
    
    <!-- Label and input field for password: User provides their password (masked) -->
    <label for="loginPassword">Password:</label>
    <input type="password" id="loginPassword" name="loginPassword" required><br>
    
    <!-- Submit button: Sends the form data to the server when clicked -->
    <button type="submit" name="loginSubmit">Login</button>
</form>

<?php
// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form has been submitted (HTTP POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Require the Member class for user authentication
    require_once(__DIR__ . '/../includes/Member.class.php');

    // Extract user input from the form
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    // Create a Member instance for authentication
    $member = new Member();

    // Attempt to authenticate user using provided credentials
    if ($member->authenticate($username, $password)) {
        // Authentication succeeded: Start a session and store username
        session_start();
        $_SESSION['username'] = $username;
        // Redirect to the member's dashboard
        header('Location: index.php?page=content/home_members.php');
        exit();
    } else {
        // Authentication failed: Display an error message
        $loginError = "Login failed. Please check your credentials.";
    }
}
?>
