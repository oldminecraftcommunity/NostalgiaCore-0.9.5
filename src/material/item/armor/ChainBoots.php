<?php

class ChainBootsItem extends ArmorItem{

	public function __construct($meta = 0, $count = 1){
		parent::__construct(CHAIN_BOOTS, $meta, $count, "Chain Boots");
	}
	
	public function getMaterialDurability(){
		return Material::CHAIN;
	}
	
	public function getBaseDurability(){
		return 13;
	}
	
}