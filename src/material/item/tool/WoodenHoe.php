<?php

class WoodenHoeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(WOODEN_HOE, $meta, $count, "Wooden Hoe");
	}

}