<?php

class GoldenBootsItem extends ArmorItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_BOOTS, $meta, $count, "Golden Boots");
	}
	
	public function getMaterialDurability(){
		return Material::GOLD;
	}
	
	public function getBaseDurability(){
		return 13;
	}
}