<?php

abstract class ItemSword extends ItemTool
{

	public function isSword(){
		return true;
	}

	public function getLevel(){
		switch($this->id){
			case WOODEN_SWORD:
				return 1;
			case GOLDEN_SWORD:
				return 2;
			case STONE_SWORD:
				return 3;
			case IRON_SWORD:
				return 4;
			case DIAMOND_SWORD:
				return 5;
			default:
				return false;
		}
	}
}

