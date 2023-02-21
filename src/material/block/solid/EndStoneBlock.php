<?php

class EndStoneBlock extends SolidBlock {
    public function __construct(){
		parent::__construct(END_STONE, 0, "End Stone");
		$this->hardness = 45;
	}

    public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){ //from pm 1.4
			case 5:
				return 0.6;
			case 4:
				return 0.75;
			case 3:
				return 1.15;
			case 2:
				return 0.4;
			case 1:
				return 2.25;
			default:
				return 15;
		}
	}

    public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array(END_STONE, 0, 1),
			);
		}else{
			return array();
		}
	}
}