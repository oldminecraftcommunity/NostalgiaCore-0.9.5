<?php

class DiamondHoeItem extends ItemHoe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_HOE, $meta, $count, "Diamond Hoe");
	}
}