<?php


/***REM_START***/
require_once("Water.php");
/***REM_END***/

class StillWaterBlock extends WaterBlock{
	public function __construct($meta = 0){
		LiquidBlock::__construct(STILL_WATER, $meta, "Still Water");
		$this->hardness = 500;
	}
	
}