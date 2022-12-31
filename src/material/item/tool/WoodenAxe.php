<?php

class WoodenAxeItem extends ItemAxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(WOODEN_AXE, $meta, $count, "Wooden Axe");
	}
	
	public function getDamageAgainstOf($e){
		return 3;
	}
}
