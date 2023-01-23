<?php

abstract class ArmorItem extends Item{ //abstract to avoid making instances of it
	
	public function isArmor(){
		return true;
	}
	
	public abstract function getMaterialDurability();
	
	public abstract function getBaseDurability();
	
	public abstract function getDamageReduceAmount();
	
	public function getMaxDurability(){
		return $this->getMaterialDurability() * $this->getBaseDurability();
	}
}