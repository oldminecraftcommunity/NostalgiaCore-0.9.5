<?php

class CoalItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(COAL, $meta & 0x01, $count, "Coal");
		if($this->meta === 1){
			$this->name = "Charcoal";
		}
	}

}