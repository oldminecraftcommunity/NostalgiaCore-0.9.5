<?php

class GravelBlock extends FallableBlock{
	public function __construct(){
		parent::__construct(GRAVEL, 0, "Gravel");
		$this->hardness = 3;
	}
	
	public function getDrops(Item $item, Player $player){
		if(mt_rand(1,10) === 1){
			return array(
				array(FLINT, 0, 1),
			);
		}
		return array(
			array(GRAVEL, 0, 1),
		);
	}
	
}