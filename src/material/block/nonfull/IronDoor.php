<?php

class IronDoorBlock extends DoorBlock{
	public function __construct($meta = 0){
		parent::__construct(IRON_DOOR_BLOCK, $meta, "Iron Door Block");
		//$this->isActivable = true;
		$this->hardness = 25;
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){
			case 5:
				return 0.95;
			case 4:
				return 1.25;
			case 3:
				return 1.9;
			case 2:
				return 0.65;
			case 1:
				return 3.75;
			default:
				return 25;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array(IRON_DOOR, 0, 1),
			);
		}else{
			return array();
		}
	}
}
