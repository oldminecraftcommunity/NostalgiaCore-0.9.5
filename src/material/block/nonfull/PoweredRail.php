<?php

class PoweredRailBlock extends FlowableBlock{
	public function __construct($meta = 0){
		parent::__construct(POWERED_RAIL, 0, "PoweredRailBlock");
		$this->hardness = 0.7;
		$this->isFullBlock = false;		
		$this->isSolid = true;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() !== AIR and $down instanceof SolidBlock){
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		} 
		return false;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getID() === AIR){ //Replace with common break method
				ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem($this->id, $this->meta, 1));
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
}