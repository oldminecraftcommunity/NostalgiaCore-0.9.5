<?php

class LeatherItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(LEATHER, 0, $count, "Leather");
	}
}
