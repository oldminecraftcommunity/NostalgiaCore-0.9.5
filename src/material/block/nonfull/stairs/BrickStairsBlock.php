<?php

class BrickStairsBlock extends StairBlock{
	public static $blockID;
	public function __construct($meta = 0){
		parent::__construct(BRICK_STAIRS, $meta, "Brick Stairs");
	}
	
}