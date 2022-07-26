<?php

class FeatherItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(FEATHER, 0, $count, "Feather");
	}

}