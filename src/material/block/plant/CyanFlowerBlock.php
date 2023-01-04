<?php

class CyanFlowerBlock extends FlowableBlock{
	public function __construct(){
		parent::__construct(CYAN_FLOWER, 0, "Cyan Flower");
		$this->hardness = 0;
	}

	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
			$down = $this->getSide(0);
			if($down->getID() === 2 or $down->getID() === 3 or $down->getID() === 60){
				$this->level->setBlock($block, $this, true, false, true);
				return true;
			}
		return false;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->isTransparent === true){ //Replace with common break method
				ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem($this->id));
				$this->level->setBlock($this, new AirBlock(), false, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
}