<?php

class WoodDoorBlock extends DoorBlock{
	public function __construct($meta = 0){
		parent::__construct(WOOD_DOOR_BLOCK, $meta, "Wood Door Block");
		$this->isActivable = true;
		$this->hardness = 15;
	}
	
	public function getDrops(Item $item, Player $player){
		return array(
			array(WOODEN_DOOR, 0, 1),
		);
	}
}
