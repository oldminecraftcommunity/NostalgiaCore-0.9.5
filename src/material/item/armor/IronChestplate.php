<?php

class IronChestplateItem extends ArmorItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(IRON_CHESTPLATE, $meta, $count, "Iron Chestplate");
	}
	
	public function getMaterialDurability(){
		return Material::IRON;
	}
	
	public function getBaseDurability(){
		return 16;
	}
}