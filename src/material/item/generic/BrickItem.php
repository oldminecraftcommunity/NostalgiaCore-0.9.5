<?php

class BrickItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BRICK, 0, $count, "Brick");
	}

}