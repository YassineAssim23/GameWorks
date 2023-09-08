<!-- Opening form tag: The form allows users to input data and send it to the server -->
<head>
<link rel="stylesheet" href="css/styles.css">
</head>
<form action="#" method="post">
    <h2>Register</h2>
    <!-- Label and input field for username: User provides desired username -->
    <label for="registerUsername">Username:</label>
    <input type="text" id="registerUsername" name="registerUsername" required><br>
    
    <!-- Label and input field for password: User provides desired password (masked) -->
    <label for="registerPassword">Password:</label>
    <input type="password" id="registerPassword" name="registerPassword" required><br>
    
    <!-- Label and input field to confirm password: User confirms the password (masked) -->
    <label for="confirmPassword">Confirm Password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" required><br>
    
    <!-- Submit button: Sends the form data to the server when clicked -->
    <button type="submit" name="registerSubmit">Register</button>
</form>

<?php
// Display errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form has been submitted (HTTP POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Require the Member class for user registration
    require_once(__DIR__ . '/../includes/Member.class.php');

    // Extract and sanitize user input from the form
    $username = $_POST['registerUsername'];
    $password = $_POST['registerPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $registerError = "Passwords do not match.";
    } else {
        // Create a Member instance for registration
        $member = new Member();

        // Attempt to register user with provided credentials
        if ($member->registerMember($username, $password)) {
            // Registration succeeded: Redirect to confirmation page
            header('Location: index.php?page=content/home_public.php');
            exit();
        } else {
            // Registration failed: Display an error message
            $registerError = "Registration failed. Please try again.";
        }
    }
}
?>
