<?php

class ItemShovel extends ItemTool
{
	public function isShovel(){
		return true;
	}

	public function getLevel(){
		switch($this->id){
			case WOODEN_SHOVEL:
				return 1;
			case GOLDEN_SHOVEL:
				return 2;
			case STONE_SHOVEL:
				return 3;
			case IRON_SHOVEL:
				return 4;
			case DIAMOND_SHOVEL:
				return 5;
			default:
				return false;
		}
	}
}

