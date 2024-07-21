<?php

abstract class ItemTool extends Item
{
	const WOODEN_LEVEL = 1;
	const GOLD_LEVEL = 2;
	const STONE_LEVEL = 3;
	const IRON_LEVEL = 4;
	const DIAMOND_LEVEL = 5;
	
	public function isTool(){
		return true;
	}
	public function useOn($object, $force = false){
		
		if($this->isSword() && !($object instanceof Entity)){
			$this->meta += 2;
		}else if(($object instanceof Entity) && !$this->isSword()){
			$this->meta += 2;
		}else{
			$this->meta++;
		}
		return true;
	}
}

