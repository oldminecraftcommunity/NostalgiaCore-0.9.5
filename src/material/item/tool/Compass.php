<?php

class CompassItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(COMPASS, 0, $count, "Compass");
		$this->maxStackSize = 1;
	}
	
}