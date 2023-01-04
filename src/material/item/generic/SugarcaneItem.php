<?php

class SugarcaneItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(SUGARCANE_BLOCK);
		parent::__construct(SUGARCANE, 0, $count, "Sugar Cane");
	}
}