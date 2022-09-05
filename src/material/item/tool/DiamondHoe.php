<?php

class DiamondHoeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_HOE, $meta, $count, "Diamond Hoe");
	}
	
	public function isTool(){
		return true;
	}
}