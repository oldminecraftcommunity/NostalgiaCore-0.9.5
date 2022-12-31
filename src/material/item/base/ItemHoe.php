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
}

