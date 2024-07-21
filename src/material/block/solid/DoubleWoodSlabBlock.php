<?php

class DoubleWoodSlabBlock extends SolidBlock{
	public static $blockID;
	public function __construct($meta = 0){
		parent::__construct(DOUBLE_WOOD_SLAB, $meta, "Double Wooden Slab");
		$names = array(
			0 => "Oak",
			1 => "Spruce",
			2 => "Birch",
			3 => "Jungle",
		);
		$this->name = "Double " . $names[$this->meta & 0x07] . " Wooden Slab";
		$this->hardness = 15;
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
			array(WOOD_SLAB, $this->meta & 0x07, 2),
		);
	}
	
}