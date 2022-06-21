<?php
/*
TODO:
move methods
*/
abstract class Animal extends Creature implements Ageable, Breedable{
	public function isBaby(){
		return $this->data["IsBaby"];
	}
	
	public function environmentUpdate(){
		if($this->server->api->getProperty("spawn-animals") !== true){
			$this->close();
			return false;
		}
		parent::environmentUpdate();
	}
}