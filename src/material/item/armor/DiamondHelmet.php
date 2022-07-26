<?php

class DiamondHelmetItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_HELMET, $meta, $count, "Diamond Helmet");
	}
}