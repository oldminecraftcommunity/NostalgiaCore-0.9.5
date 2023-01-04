<?php

class BreadItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BREAD, 0, $count, "Bread");
	}

}