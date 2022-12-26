<?php

abstract class ItemTool extends Item
{
	public function isTool(){
		return true;
	}
	public function useOn($object, $force = false){
		if(($object instanceof Entity) and !$this->isSword()){
			$this->meta += 2;
		}else{
			$this->meta++;
		}
		return true;
	}
}

