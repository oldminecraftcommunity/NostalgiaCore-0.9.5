<?php

class Reserved6Block extends SolidBlock{
	public function __construct(){
		parent::__construct(RESERVED6, 0, ".name<");
		$this->breakable = true;
		$this->hardness = 0;
	}
	
}