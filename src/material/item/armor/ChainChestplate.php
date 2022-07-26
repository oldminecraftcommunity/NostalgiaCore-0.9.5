<?php

class ChainChestplateItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(CHAIN_CHESTPLATE, $meta, $count, "Chain Chestplate");
	}
}