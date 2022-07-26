<?php

class RedstoneItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(REDSTONE, 0, $count, "Redstone");
	}

}