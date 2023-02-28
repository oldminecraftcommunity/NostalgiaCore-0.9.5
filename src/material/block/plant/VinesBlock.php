<?php

class VinesBlock extends FlowableBlock{
	public function __construct($meta = 0){
		parent::__construct(VINES, $meta, "Vines");
		$this->isSolid = false;
		$this->isFullBlock = false;
		$this->hardness = 2;
	}

	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($face === 0 || $face === 1){
			return false; //fix of placing invalid ids without array
		}
		if($target->isTransparent === false){
			$faces = array(
				2 => 0x01,
                3 => 0x04,
				4 => 0x08,
                5 => 0x02,
			);
			$this->level->setBlock($this, BlockAPI::get($this->id, $faces[$face]), true, false, true);
			return true;
		}
		return false;
	}

	public function getDrops(Item $item, Player $player){
		$drops = array();
		if($item->isShears()){
			$drops[] = array($this->id, 0, 1);
		}
		return $drops;
	}		
}
