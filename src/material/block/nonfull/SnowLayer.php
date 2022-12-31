<?php

class SnowLayerBlock extends FlowableBlock{
	public function __construct($meta = 0){
		parent::__construct(SNOW_LAYER, $meta, "Snow Layer");
		$this->isReplaceable = true;
		$this->isSolid = false;
		$this->isFullBlock = false;
		$this->hardness = 0.5;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down instanceof SolidBlock){
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		}
		return false;
	}
	
	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->getID() === AIR){ //Replace with common break method
				$this->level->setBlock($this, new AirBlock(), true, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function getDrops(Item $item, Player $player){
		if($item->isShovel() !== false){
			return array(
				array(SNOWBALL, 0, 1),
			);
		}
	}
}