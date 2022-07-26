<?php

class IronBootsItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_BOOTS, $meta, $count, "Iron Boots");
	}
}