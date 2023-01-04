<?php

class CarrotItem extends Item{
	public function __construct($meta = 0, $count = 1){
		$this->block = BlockAPI::get(CARROT_BLOCK);
		parent::__construct(CARROT, 0, $count, "Carrot");
	}
}