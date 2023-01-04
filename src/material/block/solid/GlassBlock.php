<?php

class GlassBlock extends TransparentBlock{
	public function __construct(){
		parent::__construct(GLASS, 0, "Glass");
		$this->hardness = 1.5;
	}
	
	public function getDrops(Item $item, Player $player){
		return array();
	}
}