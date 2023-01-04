<?php

/***REM_START***/
require_once("SignPostBlock.php");
/***REM_END***/

class WallSignBlock extends SignPostBlock{
	public function __construct($meta = 0){
		TransparentBlock::__construct(WALL_SIGN, $meta, "Wall Sign");
	}

	public function onUpdate($type){
		return false;
	}
}