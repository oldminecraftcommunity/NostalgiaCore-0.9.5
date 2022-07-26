<?php

class LeatherPantsItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(LEATHER_PANTS, $meta, $count, "Leather Pants");
	}
}