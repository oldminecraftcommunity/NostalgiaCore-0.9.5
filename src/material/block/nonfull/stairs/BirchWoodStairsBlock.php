<?php

class BirchWoodStairsBlock extends StairBlock{
	public static $blockID;
	public function __construct($meta = 0){
		parent::__construct(BIRCH_WOOD_STAIRS, $meta, "Birch Wood Stairs");
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}
}