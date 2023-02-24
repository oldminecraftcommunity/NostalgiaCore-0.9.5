<?php

class StainedClayBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(STAINED_CLAY, $meta, "Stained Clay");
		$names = array(
			0 => "White Stained Clay",
			1 => "Orange Stained Clay",
			2 => "Magenta Stained Clay",
			3 => "Light Blue Stained Clay",
			4 => "Yellow Stained Clay",
			5 => "Lime Stained Clay",
			6 => "Pink Stained Clay",
			7 => "Gray Stained Clay",
			8 => "Light Gray Stained Clay",
			9 => "Cyan Stained Clay",
			10 => "Purple Stained Clay",
			11 => "Blue Stained Clay",
			12 => "Brown Stained Clay",
			13 => "Green Stained Clay",
			14 => "Red Stained Clay",
			15 => "Black Stained Clay",
		);
		$this->name = $names[$this->meta & 0x15];
		$this->hardness = 30;
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){
			case 5:
				return 0.25;
			case 4:
				return 0.35;
			case 3:
				return 0.5;
			case 2:
				return 0.2;
			case 1:
				return 0.95;
			default:
				return 6.25;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array(STAINED_CLAY, $this->meta & 0x15, 1)
			);
		}else{
			return array();
		}
	}
	
}