<?php

class RawPorkchopItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(RAW_PORKCHOP, 0, $count, "Raw Porkchop");
	}

}