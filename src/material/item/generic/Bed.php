<?php

class BedItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(BED_BLOCK);
		parent::__construct(BED, 0, $count, "Bed");
		$this->maxStackSize = 1;
	}
}