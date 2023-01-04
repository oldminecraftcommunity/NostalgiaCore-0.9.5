<?php

class GoldenSwordItem extends ItemSword{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_SWORD, $meta, $count, "Golden Sword");
	}
	public function getDamageAgainstOf($e)
	{
		return 4;
	}

}