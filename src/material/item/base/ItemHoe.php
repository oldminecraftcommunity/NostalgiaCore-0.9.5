<?php

abstract class ItemHoe extends ItemTool
{
	public function isHoe(){
		return true;
	}
	
	public function useOn($object, $force = false){
		if(($object instanceof Block) and ($object->getID() === GRASS or $object->getID() === DIRT)){
			$this->meta++;
			return true;
		}else{
			return parent::useOn($object, $force);
		}
	}

	public function getLevel(){
		switch($this->id){
			case WOODEN_HOE:
				return 1;
			case GOLDEN_HOE:
				return 2;
			case STONE_HOE:
				return 3;
			case IRON_HOE:
				return 4;
			case DIAMOND_HOE:
				return 5;
			default:
				return false;
		}
	}
}

