<?php

class DiamondPickaxeItem extends ItemPickaxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_PICKAXE, $meta, $count, "Diamond Pickaxe");
	}
	
	public function getDamageAgainstOf($e){
		return 5;
	}
}