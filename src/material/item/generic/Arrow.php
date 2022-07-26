<?php

class ArrowItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(ARROW, 0, $count, "Arrow");
	}
}