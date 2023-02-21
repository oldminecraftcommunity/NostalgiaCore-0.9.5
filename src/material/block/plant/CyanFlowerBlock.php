<?php

class CyanFlowerBlock extends FlowableBlock{
	const POPPY = 0;
	const BLUE_ORCHID = 1;
	const ALLIUM = 2;
	const AZURE_BLUET = 3;
	const RED_TULIP = 4;
	const ORANGE_TULIP = 5;
	const WHITE_TULIP = 6;
	const PINK_TULIP = 7;
	const OXEYE_DAISY = 8; 

	public function __construct(){
		parent::__construct(CYAN_FLOWER, 0, "Poppy");
		$this->hardness = 0;
		$names = array(
			0 => "Poppy",
			1 => "Blue Orchid",
			2 => "Allium",
			3 => "Azure Bluet",
			4 => "Red Tulip",
			5 => "Orange Tulip",
			6 => "White Tulip",
			7 => "Pink Tulip",
			8 => "Oxeye Daisy",
		);
	}

	public function place(Item $item, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
			$down = $this->getSide(0);
			if($down->getID() === 2 or $down->getID() === 3 or $down->getID() === 60){
				$this->level->setBlock($block, $this, true, false, true);
				return true;
			}
		return false;
	}

	public function onUpdate($type){
		if($type === BLOCK_UPDATE_NORMAL){
			if($this->getSide(0)->isTransparent === true){ //Replace with common break method
				ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem($this->id));
				$this->level->setBlock($this, new AirBlock(), false, false, true);
				return BLOCK_UPDATE_NORMAL;
			}
		}
		return false;
	}
}