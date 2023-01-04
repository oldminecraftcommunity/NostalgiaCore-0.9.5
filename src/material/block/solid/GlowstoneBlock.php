<?php

class GlowstoneBlock extends TransparentBlock implements LightingBlock{
	public function __construct(){
		parent::__construct(GLOWSTONE_BLOCK, 0, "Glowstone");
		$this->hardness = 1.5;
	}
	
	public function getMaxLightValue(){
		return 15;
	}
	
	public function getDrops(Item $item, Player $player){
		return array(
			array(GLOWSTONE_DUST, 0, mt_rand(2, 4)),
		);
	}
}