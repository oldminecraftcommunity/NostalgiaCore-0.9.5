<?php

class StillLavaBlock extends LiquidBlock{
	public function __construct($meta = 0){
		parent::__construct(STILL_LAVA, $meta, "Still Lava");
		$this->hardness = 500;
	}
	
}