<?php

class EggItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(EGG, 0, $count, "Egg");
		$this->maxStackSize = 16;
	}

}