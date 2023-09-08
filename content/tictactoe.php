<!--
	File name: ttt.php
	Author: Yassine Assim
	Date created: 8 August 2023
	Date modified: 11 August 2023
	Version: 1.0
	Description:
        Webpage for users to play Tic Tac Toe
	Citations:
		http://php.net/manual/en/ref.session.php
		https://bajcar.dev.fast.sheridanc.on.ca/php10199/assign8/content/ttt.php
-->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$output = "";
$outwho = "";
$message = "";

// Reset session when start over button is clicked
if (isset($_POST['reset'])) {
	session_destroy();
	$game = array(
		"who" => 0,
		"board" => "222222222",
		"win" => -1,
		"playToken" => "XOT",
		"endGame" => -1,
		"clicked" => 9
	);
} else {
	isset($_POST['curCell'])
        ? $game["clicked"] = $_POST['curCell']
        : $game["clicked"] = 9;
	isset($_SESSION['who'])
        ? $game["who"] = $_SESSION['who']
        : $game["who"] = 0;
	isset($_SESSION['board'])
        ? $game["board"] = $_SESSION['board']
        : $game["board"] = "222222222";
	isset($_SESSION['win'])
        ? $game["win"] = $_SESSION['win']
        : $game["win"] = -1;
	isset($_SESSION['playToken'])
        ? $game["playToken"] = $_SESSION['playToken']
        : $game["playToken"] = "XOT";
	isset($_SESSION['endGame'])
        ? $game["endGame"] = $_SESSION['win']
        : $game["endGame"] = -1;
}

play($game);
	
// Game is not over, prepare board for this turn, check winner, update session variables		
function play($game) {	
	if($game["endGame"] == -1) {
		if ($game["clicked"] !== 9 )
			updateBoard(); //print_r($game); 
		displayBoard();		
		updateSession();		
	} 
} 
	
// Update session variables so we can access it next time with current game info
function updateSession() {
	global $game;
	$_SESSION['board'] = $game["board"];
	$_SESSION['who'] = $game["who"];
	$_SESSION['win'] = $game["win"];
	$_SESSION['playToken'] = $game["playToken"];
	$_SESSION['endGame'] = $game["endGame"];
}

// Identify which cell was clicked and update game state
function updateBoard() {
	global $game, $outwho;
	// Identify which button was submitted
	$cellClicked = $game['clicked'];
	if ($cellClicked !== 9 ) {
		// Get the actual button clicked. 0 to 8 correspond to respective cell
		$curPos = $cellClicked;
		// Set our game's data with player mark
		$game["board"][$curPos] = $game["who"];
		// Switch the player turn
		$game["who"] = ($game["who"]+1)%2;
		$_SESSION['who'] = $game["who"];
	} else {
		$game["who"] = 0;
		$_SESSION['who'] = $game["who"];
	}
	$outwho .= "Player ".substr($game["playToken"],$game["who"],1)." go!";
	return $outwho;
}

// Prepare board (table) for next move with current state data
function displayBoard() {
	global $game, $output, $outwho;
	$board = $game["board"];
	if ($game["clicked"] == 9) {
		for( $i = 0; $i < 9; $i++ ) {
			$output .= '<td><input  class="available" type="submit" name="curCell" placeholder="-" value="' . $i . '"></td>';
			if(($i+1)% 3 == 0  && $i < 8)
				$output .= "</tr><tr>";
		}
	}
	if ($game["clicked"] != 9) {
		$curWinner = checkWinner($game);
		for( $i = 0; $i < 9; $i++ ) {
			switch ($board[$i]) {
				case 2:
					if ($curWinner > 990)
						$output .= '<td><input  class="available" type="submit" name="curCell" placeholder="-" value="' . $i . '"></td>';
					else
						$output .= "<td class='played'></td>";
					break;
				case 0:
					if (substr_count($curWinner, $i))
						$output .= "<td class='winner'>X</td>";
					else
						$output .= "<td class='played'>X</td>";
					break;
				case 1:
					if (substr_count($curWinner, $i))
						$output .= "<td class='winner'>O</td>";
					else
						$output .= "<td class='played'>O</td>";
					break;
			}
			if(($i+1)% 3 == 0  && $i < 8)
				$output .= "</tr><tr>";
		}
	}
	return $output;
}

// Check for winner
function checkWinner($game) {
	global $_POST, $outwho, $message;
	$winner = "999";
	$board = $game["board"];
	$cellClicked = $game["clicked"];
	if ($game["clicked"] !== 9) {
		settype($cellClicked, "string");
		$winCombo = array("012","345","678","036","147","258","840","246");
		for( $row = 0; $row < 8; $row++ ) {
			// Identify which row, column, and diag has been changed by current selection
			($cellClicked < 9)
				? $idx = substr_count($winCombo[$row], $cellClicked)
				: $idx = -1;
			// Test only the changed row, columns, and diags
			if ($idx == 1) {
				if ( $board[$winCombo[$row][0]] == $board[$winCombo[$row][1]] &&
					 $board[$winCombo[$row][1]] == $board[$winCombo[$row][2]] ) {
						$game["win"] = $board[$winCombo[$row][0]];
						$winner = $winCombo[$row];
				}
			}
		}
		if ($game["win"] != -1) {
			$message = "<p>" . substr($game["playToken"],$game["win"],1) . " wins</p>";
			$outwho = "";
		}
		elseif (count_chars($board,3) == "01") {
			$message = "<p>Game over. No winner</p>";
			$outwho = "";
		}
	}
	return $winner;
}
?>

<form method="POST">
	<input type="submit" value="Start over" name="reset">
	<table class="ttt">
		<tr>
			<?= $output ?>
		</tr>
	</table>
</form>

<p><?= $message ?></p>
<h5><?= $outwho ?></h5>