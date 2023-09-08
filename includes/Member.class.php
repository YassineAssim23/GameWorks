<?php
// Class definition for handling member-related operations
class Member {
    private $db; // Database connection

    // Constructor for initializing the database connection
    public function __construct() {
        // Database credentials
        $DATABASE = "gameworks";
        $USERNAME = "gameWorksUser";
        $PASSWORD = "gameWorksPwd";
    
        try {
            // Establish a PDO database connection
            $this->db = new PDO("mysql:host=localhost;dbname=$DATABASE;charset=utf8", $USERNAME, $PASSWORD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log database connection error and halt execution
            error_log("Cannot connect to MySQL: " . $e->getMessage() . "\n", 3, "myErrors.log");
            die("Database connection failed: " . $e->getMessage());
        }

        // Test database connection with a simple query
        $testQuery = "SELECT 1";
        $testStatement = $this->db->prepare($testQuery);
        $testStatement->execute();
    }

    // Method to authenticate a user
    public function authenticate($user, $pass) {
        try {
            // SQL query to retrieve user data
            $query = "SELECT * FROM members WHERE player=:user";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user', $user);
            
            // Execute the query and handle authentication logic
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                $dbPassword = $row['secret'];
                if (password_verify($pass, $dbPassword)) {
                    $this->firstName = $row['player'];
                    $this->isLoggedIn = true;
                    $this->_setSession(); // Set session variables upon successful authentication
                    return true; // Authentication succeeded
                } else {
                    error_log("Passwords do not match. $user\n", 3, "myErrors.log");
                    return false; // Authentication failed
                }
            }
        } catch (PDOException $e) {
            error_log("Error during authentication: " . $e->getMessage() . "\n", 3, "myErrors.log");
            return false; // Authentication failed due to an exception
        }
    }

    // Method to register a new member
    public function registerMember($user, $newPass) {
        try {
            // Hash the provided password for security
            $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);
            $date = date("Y-m-d");
            $query = "INSERT INTO members (player, secret, date) 
                      VALUES (:user, :hashedPassword, :date)";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':hashedPassword', $hashedPassword);
            $stmt->bindParam(':date', $date);

            // Execute the query and handle registration logic
            if (!$stmt->execute()) {
                error_log("User already exists. $user\n", 3, "myErrors.log");
                return false; // Registration failed (user already exists)
            }

            $this->_setSession(); // Set session variables upon successful registration
            return true; // Registration succeeded
        } catch (PDOException $e) {
            error_log("Error during registration: " . $e->getMessage() . "\n", 3, "myErrors.log");
            return false; // Registration failed due to an exception
        }
    }

    // Private method to set session variables upon successful authentication/registration
    private function _setSession() {
        session_start();
        $_SESSION['loggedIn'] = true;
        $_SESSION['userName'] = $this->firstName;
        // Additional session variables as needed
    }

    // Additional methods for retrieving member data, updating information, etc.
    // ...
}
?>
