<?php

class DiamondSwordItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_SWORD, $meta, $count, "Diamond Sword");
	}

}