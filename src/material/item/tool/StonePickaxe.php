<?php

class StonePickaxeItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STONE_PICKAXE, $meta, $count, "Stone Pickaxe");
	}

}