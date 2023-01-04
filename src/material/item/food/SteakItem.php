<?php

class SteakItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STEAK, 0, $count, "Steak");
	}

}