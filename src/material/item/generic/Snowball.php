<?php

class SnowballItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(SNOWBALL, 0, $count, "Snowball");
		$this->maxStackSize = 16;
	}

}