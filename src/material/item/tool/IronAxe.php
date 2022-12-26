<?php

class IronAxeItem extends ItemAxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_AXE, $meta, $count, "Iron Axe");
	}
	
	public function getDamageAgainstOf($e){
		return 5;
	}
}