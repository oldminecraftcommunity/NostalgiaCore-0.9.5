<?php

class MushroomStewItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(MUSHROOM_STEW, 0, $count, "Mushroom Stew");
		$this->maxStackSize = 1;
	}

}