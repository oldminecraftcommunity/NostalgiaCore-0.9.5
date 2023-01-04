<?php

class NetherBrickItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(NETHER_BRICK, 0, $count, "Nether Brick");
	}

}