<?php

class GlassPaneBlock extends TransparentBlock{
	public function __construct(){
		parent::__construct(GLASS_PANE, 0, "Glass Pane");
		$this->isFullBlock = false;
		$this->isSolid = false;
	}
	public function getDrops(Item $item, Player $player){
		return array(
			array(GLASS_PANE, 0, 0),
		);
	}
}