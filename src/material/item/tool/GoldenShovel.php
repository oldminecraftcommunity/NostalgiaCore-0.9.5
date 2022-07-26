<?php

class GoldenShovelItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_SHOVEL, $meta, $count, "Golden Shovel");
	}

}