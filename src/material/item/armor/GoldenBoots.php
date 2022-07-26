<?php

class GoldenBootsItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_BOOTS, $meta, $count, "Golden Boots");
	}
}