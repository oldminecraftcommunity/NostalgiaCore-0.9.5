<?php

class AppleItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(APPLE, 0, $count, "Apple");
	}

}