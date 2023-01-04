<?php

class IronHoeItem extends ItemHoe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_HOE, $meta, $count, "Iron Hoe");
	}
}