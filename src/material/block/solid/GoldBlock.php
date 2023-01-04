<?php

class GoldBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(GOLD_BLOCK, 0, "Gold Block");
		$this->hardness = 30;
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){
			case 5:
				return 0.6;
			case 4:
				return 0.75;
			default:
				return 15;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 4){
			return array(
				array(GOLD_BLOCK, 0, 1),
			);
		}else{
			return array();
		}
	}
}