<?php
function letter($n) {
	switch ($n) {
		case 0 : return 'A'; break;
		case 1 : return 'B'; break;
		case 2 : return 'C'; break;
		case 3 : return 'D'; break;
		case 4 : return 'E'; break;
		case 5 : return 'F'; break;
		case 6 : return 'G'; break;
		case 7 : return 'H'; break;
		case 8 : return 'I'; break;
		case 9 : return 'J'; break;
	}
}

function toY($char) {
	switch ($char) {
		case 'A' : return 0; break;
		case 'B' : return 1; break;
		case 'C' : return 2; break;
		case 'D' : return 3; break;
		case 'E' : return 4; break;
		case 'F' : return 5; break;
		case 'G' : return 6; break;
		case 'H' : return 7; break;
		case 'I' : return 8; break;
		case 'J' : return 9; break;
	}
}

function showRow($r) {
	for ($c = 0; $c <= 9; $c++)
	echo substr($r, $c, 1).'  ';
}

function showGrid($c) {
	global $game;
	if ($c) { $offset = 100; } else { $offset = 0; }
	echo '  1  2  3  4  5  6  7  8  9  10';
	$i = 0; $r = 0;
	while ($i <= 99)
	{
	    echo PHP_EOL;
	    echo letter($r).' ';
	    showRow(substr($game, $i + $offset, 10));
	    $i += 10;
	    $r++;
	}
}

function setShip ($num, $x, $y, $f) {
    global $game;
    $pos = 100 + ($y * 10) + $x;
    $n = 1;
	switch ($f) {
		case 0 :  
			for ($i = 0; $i < $num; $i++) {
				$game[$pos + $i] = 'X';
			}
			break;
		case 1 :
			for ($i = 0; $i < $num; $i++) {
				$game[$pos + ($i * 10)] = 'X';
			}
			break;
	}
}

function checkShip ($num, $x, $y, $f) {
	global $game;
	$b = false;
	$s = '';
    switch ($f) {
    	case 0 :  
    		$s .= substr($game, ($y * 10) + $x +100, $num);
    		break;
    	case 1 :
    		for ($i = 0; $i < $num; $i++) {
    			$s .= substr($game, (($y + $i) * 10) + $x + 100, 1);
    		}
    		break;
    }
    $b = trim($s) == '';
	return $b;
}

function newShips () {
	global $game;
	global $arr;
	$count = count($arr);
	$i = 1;
	while ($i <= $count) {
		$hv = rand(0,1);
		switch ($hv) {
			case 0 :
				$maxX = 10 - $arr[$i]; 
				$maxY = 10;
				break;
			case 1 :
				$maxX = 10;
				$maxY = 10 - $arr[$i]; 
				break;
		}
		$pointX = rand(0, $maxX);
		$pointY = rand(0, $maxY);
		if (checkShip($arr[$i], $pointX, $pointY, $hv)) {
			setShip($arr[$i], $pointX, $pointY, $hv);
			$game .= strval($arr[$i]);
			$game .= strval($pointX);
			$game .= strval($pointY);
			$game .= strval($hv);
			$i++;
		}
	}		
}

function shoot ($x, $y) {
	for ($i = 0; $i < 100; $i++) {
		global $game;
		if ($game[$y * 10 + $x + 99] == 'X') {
			$game[$y * 10 + $x - 1] = 'X';
			$game[$y * 10 + $x + 99] = ' ';
			return true;
		} else { 
			$game[$y * 10 + $x - 1] = '-';
			return false;
		}
	}
}

function finish () {
	global $game;
	return (trim(substr($game, 100, 100)) == '');
}