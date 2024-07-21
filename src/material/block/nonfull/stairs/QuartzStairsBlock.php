<?php

class QuartzStairsBlock extends StairBlock{
	public static $blockID;
	public function __construct($meta = 0){
		parent::__construct(QUARTZ_STAIRS, $meta, "Quartz Stairs");
	}
	
}