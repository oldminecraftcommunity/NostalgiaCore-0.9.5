<?php

class LeatherBootsItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(LEATHER_BOOTS, $meta, $count, "Leather Boots");
	}
}