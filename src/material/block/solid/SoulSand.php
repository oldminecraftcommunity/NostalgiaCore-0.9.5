<?php

class SoulSandBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(SOUL_SAND, 0, "Soul Sand");
		$this->hardness = 2.5;
	}
	
}