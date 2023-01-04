<?php

class SnowBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(SNOW_BLOCK, 0, "Snow Block");
		$this->hardness = 1;
	}

	public function getDrops(Item $item, Player $player){
		if($item->isShovel() !== false){
		return array(
			array(SNOWBALL, 0, 4),
			);
		}
	}
	
}