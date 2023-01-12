<?php

abstract class ItemAxe extends ItemTool
{
	public function isAxe(){
		return true;
	}
	
	public function getLevel(){
		switch($this->id){
			case WOODEN_AXE:
				return 1;
			case GOLDEN_AXE:
				return 2;
			case STONE_AXE:
				return 3;
			case IRON_AXE:
				return 4;
			case DIAMOND_AXE:
				return 5;
			default:
				return false;
		}
	}
}

