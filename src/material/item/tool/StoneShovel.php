<?php

class StoneShovelItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STONE_SHOVEL, $meta, $count, "Stone Shovel");
	}

}