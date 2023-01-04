<?php

class MelonBlock extends TransparentBlock{
	public function __construct(){
		parent::__construct(MELON_BLOCK, 0, "Melon Block");
		$this->hardness = 5;
	}
	public function getDrops(Item $item, Player $player){
		return array(
			array(MELON_SLICE, 0, mt_rand(3, 7)),
		);
	}
}