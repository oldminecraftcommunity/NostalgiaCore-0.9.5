<?php

class SpongeBlock extends SolidBlock{
	public function __construct(){
		parent::__construct(SPONGE, "Sponge");
		$this->hardness = 3;
	}
	
}