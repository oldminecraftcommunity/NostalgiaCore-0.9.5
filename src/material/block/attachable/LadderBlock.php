<?php

class LadderBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(LADDER, $meta, "Ladder");
		$this->isSolid = false;
		$this->isFullBlock = false;
		$this->hardness = 2;
	}
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($face === 0 || $face === 1){
			return false; //fix of placing invalid ids without array
		}
		if($target->isTransparent === false){
			$this->meta = $face;
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		}
		return false;
	}

	public function onUpdate($type){
		
		if($type === BLOCK_UPDATE_NORMAL){
			$side = $this->getMetadata();
			$faces = array( //magical tranformation
					3 => 2,
					2 => 3,
					5 => 4,
					4 => 5,
			);
			if($this->getSide($faces[$side]) instanceof AirBlock){ //Replace with common break method
				ServerAPI::request()->api->entity->drop($this, BlockAPI::getItem($this->id, 0, 1));
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}		
}
