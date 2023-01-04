<?php

class IronPickaxeItem extends ItemPickaxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_PICKAXE, $meta, $count, "Iron Pickaxe");
	}
	
	public function getDamageAgainstOf($e){
		return 4;
	}
}