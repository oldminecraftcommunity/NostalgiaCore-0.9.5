<?php

class MyceliumBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(MYCELIUM, 0, "Mycelium");
		$this->isActivable = true;
		$this->hardness = 3;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_RANDOM && !$this->getSide(1)->isTransparent && mt_rand(0, 2) == 1){
			$this->level->setBlock($this, BlockAPI::get(DIRT, 0), true, false, true);
		}
		return BLOCK_UPDATE_RANDOM;
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array(DIRT, 0, 1),
		);
	}
}