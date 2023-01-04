<?php

class RawChickenItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(RAW_CHICKEN, 0, $count, "Raw Chicken");
	}

}