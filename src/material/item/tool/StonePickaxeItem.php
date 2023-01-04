<?php

class StonePickaxeItem extends ItemPickaxe{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STONE_PICKAXE, $meta, $count, "Stone Pickaxe");
	}
	
	public function getDamageAgainstOf($e){
		return 3;
	}
}