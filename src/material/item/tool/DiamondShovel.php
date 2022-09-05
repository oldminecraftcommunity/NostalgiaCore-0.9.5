<?php

class DiamondShovelItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_SHOVEL, $meta, $count, "Diamond Shovel");
	}
	
	public function isTool(){
		return true;
	}
}