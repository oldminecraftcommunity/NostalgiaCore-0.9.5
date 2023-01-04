<?php

class BakedPotatoItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BAKED_POTATO, 0, $count, "Baked Potato");
	}

}