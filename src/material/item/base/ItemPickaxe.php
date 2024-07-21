<?php

abstract class ItemPickaxe extends ItemTool
{
	
	public function isTool(){
		return true;
	}

	public function isPickaxe(){
		return true;
	}

	public function getLevel(){
		switch($this->id){
			case WOODEN_PICKAXE:
				return 1;
			case GOLDEN_PICKAXE:
				return 2;
			case STONE_PICKAXE:
				return 3;
			case IRON_PICKAXE:
				return 4;
			case DIAMOND_PICKAXE:
				return 5;
			default:
				return false;
		}
	}
}

