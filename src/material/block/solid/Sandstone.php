<?php

class SandstoneBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(SANDSTONE, $meta, "Sandstone");
		$names = array(
			0 => "Sandstone",
			1 => "Chiseled Sandstone",
			2 => "Smooth Sandstone",
		);
		$this->name = $names[$this->meta & 0x03];		
		$this->hardness = 4;
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
				array(SANDSTONE, $this->meta & 0x03, 1),
			);
		}else{
			return array();
		}
	}
	
}