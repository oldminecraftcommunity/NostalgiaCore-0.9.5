<?php

class SaddleItem extends Item{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(SADDLE, 0, $count, "Saddle");
	}
}