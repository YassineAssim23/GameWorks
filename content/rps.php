<!DOCTYPE html>
<html>
<head>
    <title>Rock-Paper-Scissors Game</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php
    // Start a new session if one doesn't exist
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in
    if (!isset($_SESSION['userName'])) {
        // User is not logged in, redirect to login page
        header('Location: login.php');
        exit();
    }

    // Function to determine the winner
    function getWinner($playerChoice, $machineChoice, $winnerMap) {
        // Your logic for determining the winner
        if ($playerChoice == $machineChoice) {
            return "TIE";
        } elseif (isset($winnerMap[$playerChoice]) && $winnerMap[$playerChoice] == $machineChoice) {
            return "PLAYER";
        } else {
            return "MACHINE";
        }
    }

    // Process form submission if Play button is clicked
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['choices'])) {
        // Capture the player's choice
        $playerChoice = $_GET['choices'];
        // Generate a random machine choice
        $machineChoices = array("paper", "scissors", "rock", "lizard", "spock");
        $machineChoice = $machineChoices[rand(0, 4)];

        // Define the winner map for Rock-Paper-Scissors
        $winnerMap = array(
            "rock" => "scissors",
            "paper" => "rock",
            "scissors" => "paper",
            "lizard" => "paper",
            "spock" => "rock"
        );

        // Get the winner result
        $result = getWinner($playerChoice, $machineChoice, $winnerMap);
    }
    ?>

    <!-- Form for player to make a choice -->
    <label for="choices">Choose: </label>
    <select name="choices" id="choices">
        <option value="rock">Rock</option>
        <option value="paper">Paper</option>
        <option value="scissors">Scissors</option>
        <option value="lizard">Lizard</option>
        <option value="spock">Spock</option>
    </select>
    <button id="playButton">Play</button>

    <!-- Display game results -->
    <div id="gameResults"></div>

    <script>
    document.getElementById("playButton").addEventListener("click", function() {
        // Get the selected choice from the dropdown
        var playerChoice = document.getElementById("choices").value;

        // Generate a random machine choice
        var machineChoices = ["paper", "scissors", "rock", "lizard", "spock"];
        var machineChoice = machineChoices[Math.floor(Math.random() * machineChoices.length)];

        // Define the winner map for Rock-Paper-Scissors
        var winnerMap = {
            "rock": "scissors",
            "paper": "rock",
            "scissors": "paper",
            "lizard": "paper",
            "spock": "rock"
        };

        // Get the winner result using the getWinner function
        var result = getWinner(playerChoice, machineChoice, winnerMap);

        // Display game results
        var gameResultsElement = document.getElementById("gameResults");
        gameResultsElement.innerHTML = "Player chose: " + playerChoice + "<br>";
        gameResultsElement.innerHTML += "Machine chose: " + machineChoice + "<br>";
        gameResultsElement.innerHTML += "Result: " + result + " wins!";
    });

    // Function to determine the winner
    function getWinner(playerChoice, machineChoice, winnerMap) {
        // Your logic for determining the winner
        if (playerChoice === machineChoice) {
        return "TIE";
    } else if (winnerMap[playerChoice] === machineChoice) {
        return "PLAYER";
    } else {
        return "MACHINE";
    }
        return result;
    }
    </script>
</body>
</html>
