<?php

require_once('functions.php');
require_once('app/Session.php');
require_once('app/Game.php');
require_once('app/Grid.php');
require_once('app/Ships.php');

$web = true;
if (!isset($_SESSION['game'])) {
	if ((substr(php_sapi_name(), 0, 3)) == 'cli')	{
		session_id($argv[1]);
		session_start();
		$game_id = $_SESSION['game_id'] = $argv[1];
		//session_write_close();
		$_REQUEST['coord'] = $argv[2];
		$web = false;
	} else {  
		// NEW GAME
		$session = new Session();
		$grid = new Grid();
		$ships = new Ships();
		$game = new Game($session->id, $grid, $ships);
		$game->newGame();
		/*$game_id = strval(rand(1, 99999));
		session_id($game_id);
		session_start();
		$_SESSION['game_id'] = $game_id;*/
		$newgame = true;
  }
}

$game = '';
/*$game = '....................................................................................................                                                                                                    ';*/
for ($i = 1; $i <= 200; $i++) {
	if ($i <= 100) { $game .= '.'; } else { $game .= ' '; }
}
$turn = 0;
$arr = array(
	1 => 5,  // 1 x Battleship 5
	2 => 4,  // 2 x Destroyer 4
	3 => 4
);


require_once('functions.php');

if ($web && $newgame) {
	newShips();
} else {
	$game = $_SESSION['game'];
	$turn = (int)$_SESSION['turn'];
	// parse_str(implode('&', array_slice($argv, 1)), $_GET);
}



if ($web) { ?>
<!doctype html>
<html>
<body>
<pre>
<?php }


$message = array(
		'error' => '*** Error ***',
		'miss'  => '*** Miss ***',
		'hit'   => '*** Hit ***',
		'sunk'  => '*** Sunk ***',
		'finish'=> 'Well done! You completed the game in '  // 15 shots
	);

$cheat = false;
$finish = false;

// SHOOT
if ((isset($_REQUEST['coord']) && (trim($_REQUEST['coord'])!='')))
{
	$coord = $_REQUEST['coord'];
	if($coord == 'show') {
		$cheat = true;
	} else {
		$symbol = strtoupper( substr( $coord, 0, 1 ) );
		$toX = (int) substr( $coord, 1, strlen( $coord ) - 1 );
		if( ( ( $symbol >= 'A' ) && ( $symbol <= 'J' ) ) && ( ( $toX >= 1 ) && ( $toX <= 10 ) ) ) {
			// shoot
			$turn++;
			if (shoot($toX, toY($symbol))) {
				if (!finish()) { echo $message['hit']; }
				else { echo $message['finish'].$turn.' shots'.PHP_EOL; $finish = true; }
			} else {
				echo $message['miss'].PHP_EOL;
			}

		} else {
			echo $message['error'].PHP_EOL;
		}
	}
} // SHOOT

echo PHP_EOL.PHP_EOL;
showGrid($cheat);
echo PHP_EOL.PHP_EOL;

if ($web) { ?>
</pre>
<form name="input" action="index.php" method="post">
Enter coordinates (row, col), e.g. A5 <input type="input" size="5" name="coord" autocomplete="off" autofocus>
<input type="hidden" name="game_id" value="<?= $game_id ?>">
<input type="submit">
</form>
<hr>
For console use [game_id] == <?= $game_id.PHP_EOL; ?>
<?php var_dump($game); echo PHP_EOL.$web; ?>

</body>
</html>
<?php
} else {
    //echo "[coord]: coordinates (row, col), e.g. A5.\n";
    echo "Usage: php -f index.php [game_id] [coord] \n";
    //exit(1);
} ?>

<?php
// session_start();
if (!$finish) {
    $game->save();
} else {
	$game->finish();
}
//session_write_close();
