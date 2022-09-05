<?php

class IronShovelItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_SHOVEL, $meta, $count, "Iron Shovel");
	}
	
	public function isTool(){
		return true;
	}
}