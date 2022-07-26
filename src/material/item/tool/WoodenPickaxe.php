<?php

class WoodenPickaxeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(WOODEN_PICKAXE, $meta, $count, "Wooden Pickaxe");
	}

}
