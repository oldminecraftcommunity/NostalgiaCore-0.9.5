<?php

class BeefItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BEEF, 0, $count, "Beef");
	}

}