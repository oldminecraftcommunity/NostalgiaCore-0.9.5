<?php

class NetherrackBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(NETHERRACK, 0, "Netherrack");
		$this->hardness = 2;
	}
	
	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){
			case 5:
				return 0.1;
			case 4:
				return 0.1;
			case 3:
				return 0.15;
			case 2:
				return 0.05;
			case 1:
				return 0.3;
			default:
				return 2;
		}
	}

	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array(NETHERRACK, 0, 1),
			);
		}else{
			return array();
		}
	}
}