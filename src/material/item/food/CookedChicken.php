<?php

class CookedChickenItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(COOKED_CHICKEN, 0, $count, "Cooked Chicken");
	}

}