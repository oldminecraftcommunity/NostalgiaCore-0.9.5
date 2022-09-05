<?php

class GoldenAxeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_AXE, $meta, $count, "Golden Axe");
	}
	
	public function isTool(){
		return true;
	}
}