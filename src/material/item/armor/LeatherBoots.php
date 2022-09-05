<?php

class LeatherBootsItem extends ArmorItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(LEATHER_BOOTS, $meta, $count, "Leather Boots");
	}
	
	public function getMaterialDurability(){
		return Material::LEATHER;
	}
	
	public function getBaseDurability(){
		return 13;
	}
}