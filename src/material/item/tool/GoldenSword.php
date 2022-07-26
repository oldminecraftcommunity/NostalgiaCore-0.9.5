<?php

class GoldenSwordItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_SWORD, $meta, $count, "Golden Sword");
	}

}