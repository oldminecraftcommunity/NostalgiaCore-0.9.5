<?php

class ClayItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(CLAY, 0, $count, "Clay");
	}

}