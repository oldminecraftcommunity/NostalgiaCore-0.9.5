<?php

class DiamondBootsItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_BOOTS, $meta, $count, "Diamond Boots");
	}
}