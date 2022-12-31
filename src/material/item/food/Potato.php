<?php

class PotatoItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(POTATO_BLOCK);
		parent::__construct(POTATO, 0, $count, "Potato");
	}
	
}