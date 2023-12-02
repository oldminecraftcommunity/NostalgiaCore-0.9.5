<?php

class RedMushroomSolidBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(RED_MUSHROOM_BLOCK, $meta, "Mushroom");
	}
	
	public function getDrops(Item $item, Player $player){
		return [
			[RED_MUSHROOM, 0, mt_rand(0, 2)]
		];
	}
}

