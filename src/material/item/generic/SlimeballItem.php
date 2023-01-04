<?php

class SlimeballItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(SLIMEBALL, 0, $count, "Slimeball");
	}

}