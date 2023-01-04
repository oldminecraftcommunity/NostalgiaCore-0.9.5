<?php

class StickItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(STICK, 0, $count, "Stick");
	}

}