<?php

class ObsidianBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(OBSIDIAN, 0, "Obsidian");
		$this->hardness = 6000;		
	}
	
	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}
		if($item->isPickaxe() >= 5){
			return 3.5;//from wiki
		}else{
			return 250;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->isPickaxe() >= 5){
			return array(
				array(OBSIDIAN, 0, 1),
			);
		}else{
			return array();
		}
	}
}