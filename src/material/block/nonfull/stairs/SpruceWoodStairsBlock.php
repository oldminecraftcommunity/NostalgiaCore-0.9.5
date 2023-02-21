<?php

class SpruceWoodStairsBlock extends StairBlock{
	public function __construct($meta = 0){
		parent::__construct(SPRUCE_WOOD_STAIRS, $meta, "Spruce Wood Stairs");
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->isAxe()){
			case 5:
				return 0.4;
			case 4:
				return 0.5;
			case 3:
				return 0.75;
			case 2:
				return 0.25;
			case 1:
				return 1.5;
			default:
				return 3;
		}
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}
}