<?php


/***REM_START***/
require_once("WaterBlock.php"); //TODO class loader?
/***REM_END***/

class StillWaterBlock extends WaterBlock{
	public function __construct($meta = 0){
		LiquidBlock::__construct(STILL_WATER, $meta, "Still Water");
		$this->hardness = 500;
	}
	
}