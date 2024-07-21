<?php

class WorkbenchBlock extends SolidBlock{
	public static $blockID;
	public function __construct($meta = 0){
		parent::__construct(WORKBENCH, $meta, "Crafting Table");
		$this->isActivable = true;
		$this->hardness = 15;
	}
	
	public function onActivate(Item $item, Player $player){
		$player->toCraft[-1] = 1;
		return true;
	}

	public function getDrops(Item $item, Player $player){
		return array(
			array($this->id, 0, 1),
		);
	}
}