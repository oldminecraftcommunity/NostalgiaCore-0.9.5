<?php

class IronBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(IRON_BLOCK, 0, "Iron Block");
		$this->hardness = 30;
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
			default:
				return 25;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 3){
			return array(
				array(IRON_BLOCK, 0, 1),
			);
		}else{
			return array();
		}
	}
}