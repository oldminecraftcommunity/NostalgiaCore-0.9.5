<?php

class GoldenShovelItem extends ItemShovel{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_SHOVEL, $meta, $count, "Golden Shovel");
	}
}