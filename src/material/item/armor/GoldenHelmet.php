<?php

class GoldenHelmetItem extends ArmorItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(GOLDEN_HELMET, $meta, $count, "Golden Helmet");
	}
	
	public function getMaterialDurability(){
		return Material::GOLD;
	}
	
	public function getBaseDurability(){
		return 11;
	}
}