<?php

class LeatherCapItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(LEATHER_CAP, $meta, $count, "Leather Cap");
	}
}