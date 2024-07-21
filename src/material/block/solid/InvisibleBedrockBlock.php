<?php

class InvisibleBedrockBlock extends SolidBlock{
	public static $blockID;
	public function __construct(){
		parent::__construct(INVISIBLE_BEDROCK, 0, ".name<");
		$this->breakable = false;
		$this->hardness = 3600000;
	}
	
	public function isBreakable(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return true;
		}
		return false;
	}
	
}