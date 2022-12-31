<?php

class GoldenHoeItem extends ItemHoe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_HOE, $meta, $count, "Golden Hoe");
	}
}