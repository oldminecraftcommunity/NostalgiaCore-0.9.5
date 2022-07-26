<?php

class BeetrootSoupItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BEETROOT_SOUP, 0, $count, "Beetroot Soup");
		$this->maxStackSize = 1;
	}

}