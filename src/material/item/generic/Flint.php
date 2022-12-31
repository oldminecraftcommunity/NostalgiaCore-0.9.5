<?php

class FlintItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(FLINT, 0, $count, "Flint");
	}

}