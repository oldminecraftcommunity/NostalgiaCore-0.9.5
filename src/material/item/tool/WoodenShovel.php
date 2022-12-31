<?php

class WoodenShovelItem extends ItemShovel{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(WOODEN_SHOVEL, $meta, $count, "Wooden Shovel");
	}
}
