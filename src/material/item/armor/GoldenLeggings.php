<?php

class GoldenLeggingsItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_LEGGINGS, $meta, $count, "Golden Leggings");
	}
}