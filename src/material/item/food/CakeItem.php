<?php

class CakeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(CAKE, 0, $count, "Cake");
		$this->block = BlockAPI::get(CAKE_BLOCK);
		$this->maxStackSize = 1;
	}
}