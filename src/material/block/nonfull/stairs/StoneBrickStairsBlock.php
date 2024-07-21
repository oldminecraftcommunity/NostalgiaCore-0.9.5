<?php

class StoneBrickStairsBlock extends StairBlock{
	public static $blockID;
	public function __construct($meta = 0){
		parent::__construct(STONE_BRICK_STAIRS, $meta, "Stone Brick Stairs");
	}
	
}