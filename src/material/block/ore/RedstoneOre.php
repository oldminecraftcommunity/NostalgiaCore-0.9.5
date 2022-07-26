<?php

class RedstoneOreBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(REDSTONE_ORE, 0, "Redstone Ore");
		$this->hardness = 15;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL or $type === BLOCK_UPDATE_TOUCH){
			$this->level->setBlock($this, BlockAPI::get(GLOWING_REDSTONE_ORE, $this->meta), false, false, true);
			$this->level->scheduleBlockUpdate(new Position($this, 0, 0, $this->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
			return BLOCK_UPDATE_WEAK;
		}
		return false;
	}

	public function getDrops(Item $item, Player $player){
		if($item->isPickaxe() >= 2){
			return array(
				array(REDSTONE_DUST, 0, mt_rand(4, 5)),
			);
		}else{
			return array();
		}
	}
}