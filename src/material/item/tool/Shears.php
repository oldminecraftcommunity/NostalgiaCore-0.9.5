<?php

class ShearsItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(SHEARS, $meta, $count, "Shears");
	}
	
	public function isTool(){
		return true;
	}
}