<?php

class GoldenPickaxeItem extends ItemPickaxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_PICKAXE, $meta, $count, "Golden Pickaxe");
	}
	
	public function getDamageAgainstOf($e){
		return 2;
	}
}