<?php

class IronDoorItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(IRON_DOOR_BLOCK);
		parent::__construct(IRON_DOOR, 0, $count, "Iron Door");
		$this->maxStackSize = 1;
	}
}