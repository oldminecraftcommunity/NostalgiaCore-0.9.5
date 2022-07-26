<?php

class IronIngotItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_INGOT, 0, $count, "Iron Ingot");
	}

}