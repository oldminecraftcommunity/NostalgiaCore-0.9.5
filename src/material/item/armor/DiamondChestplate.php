<?php

class DiamondChestplateItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_CHESTPLATE, $meta, $count, "Diamond Chestplate");
	}
}