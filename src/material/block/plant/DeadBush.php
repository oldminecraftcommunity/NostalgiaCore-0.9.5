<?php

class DeadBushBlock extends FlowableBlock{
	public function __construct(){
		parent::__construct(DEAD_BUSH, 0, "Dead Bush");
		//$this->isReplaceable = true;
		$this->hardness = 0;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->isTransparent === true){ //Replace with common break method
				$this->level->setBlock($this, new AirBlock(), false, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
	
	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$down = $this->getSide(0);
		if($down->getID() == 12){
			$this->level->setBlock($block, $this, true, false, true);
			return true;
		} 
		return false;
	}
	
		public function getDrops(Item $item, Player $player){
			if($item->isShears()){
				return array(
				array(DEAD_BUSH, 0, 1),
			);
			}
		}
}