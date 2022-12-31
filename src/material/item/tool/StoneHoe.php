<?php

class StoneHoeItem extends ItemHoe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STONE_HOE, $meta, $count, "Stone Hoe");
	}
}