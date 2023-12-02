<?php

class BrownMushroomSolidBlock extends SolidBlock{
	public function __construct($meta = 0){
		parent::__construct(BROWN_MUSHROOM_BLOCK, $meta, "Mushroom");
	}
	
	public function getDrops(Item $item, Player $player){
		return [
			[BROWN_MUSHROOM, 0, mt_rand(0, 2)]
		];
	}
}

