<?php

class IronLeggingsItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_LEGGINGS, $meta, $count, "Iron Leggings");
	}
}