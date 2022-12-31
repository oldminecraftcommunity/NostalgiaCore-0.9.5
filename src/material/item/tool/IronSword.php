<?php

class IronSwordItem extends ItemSword{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_SWORD, $meta, $count, "Iron Sword");
	}
	public function getDamageAgainstOf($e){
		return 6;
	}
}