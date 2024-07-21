<?php

class NetherBricksStairsBlock extends StairBlock{
	public static $blockID;
	public function __construct($meta = 0){
		parent::__construct(NETHER_BRICKS_STAIRS, $meta, "Nether Bricks Stairs");
	}
	
}