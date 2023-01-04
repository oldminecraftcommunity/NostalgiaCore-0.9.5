<?php

class MelonSeedsItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(MELON_STEM);
		parent::__construct(MELON_SEEDS, 0, $count, "Melon Seeds");
	}
}