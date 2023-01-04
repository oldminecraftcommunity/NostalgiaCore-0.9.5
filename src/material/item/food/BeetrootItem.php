<?php

class BeetrootItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BEETROOT, 0, $count, "Beetroot");
	}

}