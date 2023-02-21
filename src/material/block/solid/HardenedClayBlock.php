<?php

class HardenedClayBlock extends SolidBlock {
    public function __construct(){
		parent::__construct(HARDENED_CLAY, 0, "Hardened Clay");
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
				array(HARDENED_CLAY, 0, 1),
			);
		}else{
			return array();
		}
	}

}