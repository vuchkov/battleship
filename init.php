<?php

/**
 * Created by Ilcho Vuchkov
 * http://www.vuchkov.biz
*/

$number = array(
		'A' => 0,
		'B' => 1,
		'C' => 2,
		'D' => 3,
		'E' => 4,
		'F' => 5,
		'G' => 6,
		'H' => 7,
		'I' => 8,
		'J' => 9
	);

$letter = array_flip($number);

$x = range(0, 9);
$z = array();

for ($i = 1; $i <= 10; $i++) {
	for ($k = 1; $k <= 10; $k++) {
		$z[$i][$k] = 0;
	}
}

/**
 * @return string
 */
function toString($arr, $count = 100)
{
	$max = floor(sqrt($count));
	$str = '';
	for ($i = 1; $i <= $max; $i++) {
		for ($k = 1; $k <= $max; $k++) {
			$str .= strval($z[$i][$k]);
		}
	}
	return $str;
}

/**
 * @return (int) array
 */
function fromString($str, $count = 100)
{
	$max = floor(sqrt($count));
	$arr = array();
	for ($i = 1; $i <= $max; $i++) {
		for ($k = 1; $k <= $max; $k++) {
			$arr[$i][$k] = (int)$str[($i - 1) * 10 + ($k - 1)];
		}
	}
	return $arr;
}

/**
 * @return string
 */
function initString($max = 100, $val = 0)
{
	$str = '';
	for ($i = 0; $i < $max; $i++) {
		$str .= strval($val);
}
	return $str;
}