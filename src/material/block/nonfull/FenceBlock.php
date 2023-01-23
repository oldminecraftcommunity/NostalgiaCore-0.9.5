<?php

class FenceBlock extends TransparentBlock{
	public function __construct(){
		parent::__construct(FENCE, 0, "Fence");
		$this->isFullBlock = false;
		$this->hardness = 15;
	}
	
	
	
}