<?php

class StoneWallBlock extends TransparentBlock{
	public function __construct($meta = 0){
		$meta &= 0x01;
		parent::__construct(STONE_WALL, $meta, "Cobblestone Wall");
		if($meta === 1){
			$this->name = "Mossy Cobblestone Wall";
		}
		$this->isFullBlock = false;
		$this->isSolid = false;
		$this->hardness = 30;
	}
	
}