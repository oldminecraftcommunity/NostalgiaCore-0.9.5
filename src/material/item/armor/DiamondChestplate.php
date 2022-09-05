<?php

class DiamondChestplateItem extends ArmorItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(DIAMOND_CHESTPLATE, $meta, $count, "Diamond Chestplate");
	}
	
	public function getMaterialDurability(){
		return Material::DIAMOND;
	}
	
	public function getBaseDurability(){
		return 16;
	}
}