<?php
/*
TODO:
move methods
*/
class Animal extends Creature implements Ageable{
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