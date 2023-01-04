<?php

class BrownMushroomBlock extends FlowableBlock{
	public function __construct(){
		parent::__construct(BROWN_MUSHROOM, 0, "Brown Mushroom");
		$this->hardness = 0;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->isTransparent === true){ //Replace with common break method
				ServerAPI::request()->api->entity->drop(new Position($this->x+0.5, $this->y, $this->z+0.5, $this->level), BlockAPI::getItem($this->id));
				$this->level->setBlock($this, new AirBlock(), false, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
			$down = $this->getSide(0);
			if($down->isTransparent === false){
				$this->level->setBlock($block, $this, true, false, true);
				return true;
			}
		return false;
	}		
}