<?php

class IronBarsBlock extends TransparentBlock{
	public function __construct(){
		parent::__construct(IRON_BARS, 0, "Iron Bars");
		$this->isFullBlock = false;
		$this->isSolid = false;
	}
	
}