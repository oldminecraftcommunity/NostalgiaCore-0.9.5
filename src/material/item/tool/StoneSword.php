<?php

class StoneSwordItem extends ItemSword{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STONE_SWORD, $meta, $count, "Stone Sword");
	}
	public function getDamageAgainstOf($e){
		return 5;
	}
}