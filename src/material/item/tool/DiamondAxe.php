<?php

class DiamondAxeItem extends ItemAxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_AXE, $meta, $count, "Diamond Axe");
	}
	
	public function getDamageAgainstOf($e){
		return 6;
	}
}