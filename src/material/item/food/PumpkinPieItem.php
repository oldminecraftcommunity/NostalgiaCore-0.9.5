<?php

class PumpkinPieItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(PUMPKIN_PIE, 0, $count, "Pumpkin Pie");
	}

}