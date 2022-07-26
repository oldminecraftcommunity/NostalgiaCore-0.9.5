<?php

class BoneItem extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(BONE, 0, $count, "Bone");
	}
	
}