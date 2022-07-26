<?php

class ChainBootsItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(CHAIN_BOOTS, $meta, $count, "Chain Boots");
	}
}