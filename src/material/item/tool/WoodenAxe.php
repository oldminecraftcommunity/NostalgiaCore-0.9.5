<?php

class WoodenAxeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(WOODEN_AXE, $meta, $count, "Wooden Axe");
	}

}
