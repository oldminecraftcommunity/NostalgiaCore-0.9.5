<?php

class StoneWallBlock extends TransparentBlock{
	public function __construct($meta = 0){
		parent::__construct(COBBLESTONE_WALL, $meta & 0x01, $meta === 1 ? "Mossy Cobblestone Wall" : "Cobblestone Wall");
		$this->isFullBlock = false;
		$this->isSolid = false;
		$this->hardness = 30;
	}

	public function getDrops(Item $item, Player $player){
		if($item->isPickaxe()){
			return [[COBBLESTONE_WALL, $this->getMetadata(), 1]];
		}
		return [];
	}
}