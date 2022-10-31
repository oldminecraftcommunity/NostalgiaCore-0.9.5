<?php

class IronShovelItem extends ItemShovel{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_SHOVEL, $meta, $count, "Iron Shovel");
	}
	
	public function getDamageAgainstOf($e){
		return 3;
	}
}