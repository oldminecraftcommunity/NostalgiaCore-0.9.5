<?php

class SpongeBlock extends SolidBlock{
	public static $blockID;
	public function __construct(){
		parent::__construct(SPONGE, 0, "Sponge");
		$this->hardness = 3;
	}
	
}
