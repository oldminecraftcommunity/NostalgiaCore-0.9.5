<?php

class StoneAxeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STONE_AXE, $meta, $count, "Stone Axe");
	}
	
	public function isTool(){
		return true;
	}
}