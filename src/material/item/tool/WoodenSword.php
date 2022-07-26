<?php

class WoodenSwordItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(WOODEN_SWORD, $meta, $count, "Wooden Sword");
	}

}
