<?php

class GlowingRedstoneOreBlock extends SolidBlock implements LightingBlock{
	public function __construct(){
		parent::__construct(GLOWING_REDSTONE_ORE, 0, "Glowing Redstone Ore");
		$this->hardness = 15;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_SCHEDULED or $type === BLOCK_UPDATE_RANDOM){
			$this->level->setBlock($this, BlockAPI::get(REDSTONE_ORE, $this->meta), false, false, true);			
			return BLOCK_UPDATE_WEAK;
		}else{
			$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
		}
		return false;
	}
	public function getMaxLightValue(){
		return 9;
	}

	public function getBreakTime(Item $item, Player $player){
		if(($player->gamemode & 0x01) === 0x01){
			return 0.20;
		}		
		switch($item->isPickaxe()){
			case 5:
				return 0.6;
			case 4:
				return 0.75;
			default:
				return 15;
		}
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->isPickaxe() >= 4){
			return array(
				array(REDSTONE_DUST, 0, mt_rand(4, 5)),
			);
		}else{
			return array();
		}
	}
	
}