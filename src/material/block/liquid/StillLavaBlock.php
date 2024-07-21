<?php
require_once("LiquidBlockStatic.php"); //TODO class loader?

class StillLavaBlock extends LiquidBlockStatic{
	public static $blockID = STILL_LAVA;
	public function __construct($meta = 0){
		parent::__construct(STILL_LAVA, $meta, "Still Lava");
		$this->hardness = 500;
	}
	
	public static function getTickDelay(){
		return 30;
	}
	
}