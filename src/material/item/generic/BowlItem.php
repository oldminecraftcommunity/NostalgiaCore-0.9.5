<?php

class BowlItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BOWL, 0, $count, "Bowl");
	}

}