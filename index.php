<?php

$web = true;

if (!isset($_SESSION['game_id'])) 
{
	if ((substr(php_sapi_name(), 0, 3)) == 'cli')
	{
		$game_id = ($argv[1]);
		$_REQUEST['coord'] = $argv[2];
		$web = false;
	}
	else
	{
		if (isset($_POST['game_id']) && $_POST['game_id']!=='')
		{
			$game_id = $_POST['game_id'];
		}
		else
		{
			$game_id = strval(rand(1,99999));
		}
	}
	session_id($game_id);
	session_start(); 
	$grid = '00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001111';
	$turn = 0;
}
else
{
	$game_id = $_SESSION['game_id'];
	$grid = $_SESSION['game'];
	$turn = (int)$_SESSION['turn'];
}
// DEBUG
var_dump($_SESSION);
echo '<br><hr>';

require_once('init.php');
require_once('app/Game.php');
require_once('app/Grid.php');
require_once('app/Ships.php');

$game = new Game($game_id, $grid, $turn);

$status = '';  // SHOOT
if ((isset($_REQUEST['coord']) && (trim($_REQUEST['coord'])!=='')))
{
	$status = $game->action($_REQUEST['coord']);
}

$game->view($web, $status);

$_SESSION['game_id'] = strval($game->gameId);
$_SESSION['game'] = $game->grid->str();
$_SESSION['turn'] = strval($game->turn);
session_write_close();
if (!$web)
{
    //exit(1);
}

echo '<hr>DEBUG<br>';
var_dump($_SESSION);