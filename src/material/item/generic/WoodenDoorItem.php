<?php

class WoodenDoorItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(WOODEN_DOOR_BLOCK);
		parent::__construct(WOODEN_DOOR, 0, $count, "Wooden Door");
		$this->maxStackSize = 1;
	}
}