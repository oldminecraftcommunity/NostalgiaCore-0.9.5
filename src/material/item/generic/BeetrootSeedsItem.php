<?php

class BeetrootSeedsItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(BEETROOT_BLOCK);
		parent::__construct(BEETROOT_SEEDS, 0, $count, "Beetroot Seeds");
	}
}