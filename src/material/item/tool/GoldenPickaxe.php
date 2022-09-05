<?php

class GoldenPickaxeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_PICKAXE, $meta, $count, "Golden Pickaxe");
	}
	
	public function isTool(){
		return true;
	}
}