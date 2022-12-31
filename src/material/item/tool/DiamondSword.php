<?php

class DiamondSwordItem extends ItemSword{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_SWORD, $meta, $count, "Diamond Sword");
	}
	public function getDamageAgainstOf($e)
	{
		return 7;
	}

}