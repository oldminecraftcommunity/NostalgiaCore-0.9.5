<?php

class FlintSteelItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(FLINT_STEEL, $meta, $count, "Flint and Steel");
		$this->isActivable = true;
		$this->maxStackSize = 1;
	}
	
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if(($player->gamemode & 0x01) === 0 and $this->useOn($block) and $this->getMetadata() >= $this->getMaxDurability()){
			$player->setSlot($player->slot, new Item(AIR, 0, 0), false);
		}

		if($block->getID() === AIR and ($target instanceof SolidBlock)){
			$level->setBlock($block, new FireBlock(), true, false, true);
			$block->level->scheduleBlockUpdate(new Position($block, 0, 0, $block->level), Utils::getRandomUpdateTicks(), BLOCK_UPDATE_RANDOM);
			return true;
		}
		return false;
	}
	
	public function isTool(){
		return true;
	}
}