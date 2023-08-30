<?php

class StoneBlock extends SolidBlock{
	
	protected static $names = [
		0 => "Stone",
		1 => "Granite",
		2 => "Polished Granite",
		3 => "Diorite",
		4 => "Polished Diorite",
		5 => "Andesite",
		6 => "Polished Andesite",
	];
	
	public function __construct($meta = 0){
		parent::__construct(STONE, $meta, self::$names[$meta] ?? "Stone");
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
				array($this->meta == 0 ? COBBLESTONE : $this->id, $this->meta, 1),
			);
		}else{
			return array();
		}
	}
	
}