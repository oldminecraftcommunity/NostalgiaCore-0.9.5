<?php

class WheatSeedsItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(WHEAT_BLOCK);
		parent::__construct(WHEAT_SEEDS, 0, $count, "Wheat Seeds");
	}
}