<?php

class GunpowderItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(GUNPOWDER, 0, $count, "Gunpowder");
	}

}