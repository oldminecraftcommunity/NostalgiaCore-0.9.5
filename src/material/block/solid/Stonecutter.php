<?php

class StonecutterBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(STONECUTTER, $meta, "Stonecutter");
		$this->isActivable = true;
	}
	
	public function onActivate(Item $item, Player $player){
		$player->toCraft[-1] = 2;
		return true;
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}	
}