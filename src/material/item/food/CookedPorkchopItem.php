<?php

class CookedPorkchopItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(COOKED_PORKCHOP, 0, $count, "Cooked Porkchop");
	}
	
}