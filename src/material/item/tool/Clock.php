<?php

class ClockItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(CLOCK, 0, $count, "Clock");
	}

}