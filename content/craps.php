<!-- content/craps.php -->

<?php
// Check if the user is logged in
if (!isset($_SESSION['userName'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="css/styles.css">
	<title>Object-Oriented Casino Craps (PHP)</title>
	<meta charset="utf-8">
</head>
<body>
	<!-- Create a button for rolling the dice -->
	<button id="roll">ROLL</button>
	<!-- Display area for the game output -->
	<output></output>
	<script>
	class CasinoCrapsGame {
		constructor() {
			// Initialize the point to 0 and an empty output
			this.point = 0;
			this.output = "";
		}

		// Method to simulate rolling a six-sided die
		roll() {
			return Math.floor(Math.random() * 6) + 1;
		}

		// Method to display game messages and results
		display(msg, point = 0) {
			const message = {
				natural: " That's a natural. You win! \n\nNEW GAME ",
				craps: " That's craps. You lose! \n\nNEW GAME ",
				point: " You made your point. You win! \n\nNEW GAME ",
				seven: " That's a seven. You lose! \n\nNEW GAME ",
				reroll: " ...Roll again!"
			};

			if (point === 0) {
				this.output += message[msg];
			} else {
				this.output += ` Your point is ${point}${message[msg]}`;
			}
		}

		// Method to simulate rolling two dice and determining outcome
		rollBoth() {
			const alpha = this.roll();
			const bravo = this.roll();
			const total = alpha + bravo;
			this.output += `\n${alpha} + ${bravo} = ${total} `;
			this.determineOutcome(total);
		}

		// Method to determine the game outcome based on the point and roll total
		determineOutcome(total) {
			switch (this.point) {
				case 0:
					switch (total) {
						case 7:
						case 11:
							this.display("natural");
							break;
						case 2:
						case 3:
						case 12:
							this.display("craps");
							break;
						default:
							this.point = total;
							this.display("reroll", this.point);
							break;
					}
					break;
				default:
					switch (total) {
						case this.point:
							this.display("point");
							this.point = 0;
							break;
						case 7:
							this.display("seven");
							this.point = 0;
							break;
						default:
							this.display("reroll");
							break;
					}
					break;
			}
		}
	}

	// Create a new instance of the CasinoCrapsGame class
	const game = new CasinoCrapsGame();

	// Add an event listener to the roll button
	document.getElementById("roll").onclick = () => {
		// Roll the dice and update the game output
		game.rollBoth();
		document.getElementsByTagName("output")[0].innerText = game.output;
	};
	</script>
</body>
</html>
