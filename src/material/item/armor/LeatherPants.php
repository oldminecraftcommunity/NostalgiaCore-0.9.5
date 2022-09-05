<?php

class LeatherPantsItem extends ArmorItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(LEATHER_PANTS, $meta, $count, "Leather Pants");
	}
	
	public function getMaterialDurability(){
		return Material::LEATHER;
	}
	
	public function getBaseDurability(){
		return 15;
	}
}