<?php

/**
 * Created by Ilcho Vuchkov
 * http://www.vuchkov.biz
*/

class Battleship extends Ship {

	const SPACES = 5;
	const NAME = "Battleship";
	const CODE = "1";

	public function __construct() {
		parent::__construct(self::SPACES,self::NAME,self::CODE);
	}

}
