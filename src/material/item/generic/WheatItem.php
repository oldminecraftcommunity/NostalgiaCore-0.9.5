<?php

class WheatItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(WHEAT, 0, $count, "Wheat");
	}

}