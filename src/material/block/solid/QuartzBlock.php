<?php

class QuartzBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(QUARTZ_BLOCK, $meta, "Quartz Block");
		$names = array(
			0 => "Quartz Block",
			1 => "Chiseled Quartz Block",
			2 => "Quartz Pillar",
			3 => "Quartz Pillar",
		);
		$this->name = $names[$this->meta & 0x03];
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){
			case 5:
				return 0.15;
			case 4:
				return 0.2;
			case 3:
				return 0.3;
			case 2:
				return 0.1;
			case 1:
				return 0.6;
			default:
				return 4;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array(QUARTZ_BLOCK, $this->meta & 0x03, 1),
			);
		}else{
			return array();
		}
	}
}