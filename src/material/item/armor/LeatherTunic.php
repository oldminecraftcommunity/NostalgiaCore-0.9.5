<?php

class LeatherTunicItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(LEATHER_TUNIC, $meta, $count, "Leather Tunic");
	}
}