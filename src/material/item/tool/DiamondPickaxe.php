<?php

class DiamondPickaxeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_PICKAXE, $meta, $count, "Diamond Pickaxe");
	}
	
	public function isTool(){
		return true;
	}
}