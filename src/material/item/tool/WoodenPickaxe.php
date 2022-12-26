<?php

class WoodenPickaxeItem extends ItemPickaxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(WOODEN_PICKAXE, $meta, $count, "Wooden Pickaxe");
	}
	
	public function getDamageAgainstOf($e){
		return 2;
	}
}
