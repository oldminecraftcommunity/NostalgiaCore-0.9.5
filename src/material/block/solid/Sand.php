<?php

class SandBlock extends FallableBlock{
	public function __construct(){
		parent::__construct(SAND, 0, "Sand");
		$this->hardness = 2.5;
	}
	
}