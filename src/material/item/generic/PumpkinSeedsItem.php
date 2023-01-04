<?php

class PumpkinSeedsItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(PUMPKIN_STEM);
		parent::__construct(PUMPKIN_SEEDS, 0, $count, "Pumpkin Seeds");
	}
}