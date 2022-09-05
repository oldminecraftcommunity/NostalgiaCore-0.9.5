<?php

class IronLeggingsItem extends ArmorItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_LEGGINGS, $meta, $count, "Iron Leggings");
	}
	
	public function getMaterialDurability(){
		return Material::IRON;
	}
	
	public function getBaseDurability(){
		return 15;
	}
}