<?php

class GoldenAxeItem extends ItemAxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_AXE, $meta, $count, "Golden Axe");
	}
	public function getDamageAgainstOf($e){
		return 3;
	}
}