<?php

class EmeraldOreBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(EMERALD_ORE, 0, "Emerald Ore");
		$this->hardness = 15;
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
				array(EMERALD, 0, 1),
			);
		}else{
			return array();
		}
	}
}