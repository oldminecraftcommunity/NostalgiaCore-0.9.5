<?php

class SugarItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(SUGAR, 0, $count, "Sugar");
	}

}