<?php

class MelonItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(MELON, 0, $count, "Melon");
	}

}