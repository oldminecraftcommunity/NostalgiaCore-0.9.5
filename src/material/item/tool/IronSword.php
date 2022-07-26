<?php

class IronSwordItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_SWORD, $meta, $count, "Iron Sword");
	}

}