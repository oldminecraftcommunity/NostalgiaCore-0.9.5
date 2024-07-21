<?php

class LiquidBlockStatic extends LiquidBlock{
	public function __construct($id, $meta = 0, $name = "Unknown"){
		parent::__construct($id, $meta, $name);
	}
	public static $blockID = 0;
	//TODO: tick: try spread fire if lava
	
	public static function setDynamic(Level $level, $x, $y, $z){
		[$id, $meta] = $level->level->getBlock($x, $y, $z);
		$dynamicID = $id - 1; //very unsafe
		$level->fastSetBlockUpdate($x, $y, $z, $dynamicID, $meta);		
	}
	
	public static function neighborChanged(Level $level, $x, $y, $z, $nX, $nY, $nZ, $oldID){
		$oldID = $level->level->getBlockID($x, $y, $z);
		static::updateLiquid($level, $x, $y, $z);
		$newID = $level->level->getBlockID($x, $y, $z);
		if($oldID == $newID){
			static::setDynamic($level, $x, $y, $z);
		}
	}
	
	
}