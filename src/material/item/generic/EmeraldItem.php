<?php

class EmeraldItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(EMERALD, 0, $count, "Emerald");
	}

}