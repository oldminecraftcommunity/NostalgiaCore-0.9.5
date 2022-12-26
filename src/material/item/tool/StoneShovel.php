<?php

class StoneShovelItem extends ItemShovel{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STONE_SHOVEL, $meta, $count, "Stone Shovel");
	}
	
	public function getDamageAgainstOf($e){
		return 2;
	}
	
}