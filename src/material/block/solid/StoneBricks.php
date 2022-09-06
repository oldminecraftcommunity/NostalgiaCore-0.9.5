<?php

class StoneBricksBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(STONE_BRICKS, $meta, "Stone Bricks");
		$names = array(
			0 => "Stone Bricks",
			1 => "Mossy Stone Bricks",
			2 => "Cracked Stone Bricks",
			3 => "Chiseled Stone Bricks",
		);
		$this->name = $names[$this->meta & 0x03];
		$this->hardness = 30;
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->getPickaxeLevel()){
			case 5:
				return 0.4;
			case 4:
				return 0.5;
			case 3:
				return 0.75;
			case 2:
				return 0.25;
			case 1:
				return 1.5;
			default:
				return 7.5;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->getPickaxeLevel() >= 1){
			return array(
				array(STONE_BRICKS, $this->meta & 0x03, 1),
			);
		}else{
			return array();
		}
	}
	
}