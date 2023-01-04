<?php

class ShearsItem extends ItemTool{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(SHEARS, $meta, $count, "Shears");
	}
	
	public function useOn($object, $force = false){
		if(($object instanceof Sheep) and $this->id === SHEARS){
			$this->meta++;
			return true;
		}
		parent::useOn($object, $force);
	}
}