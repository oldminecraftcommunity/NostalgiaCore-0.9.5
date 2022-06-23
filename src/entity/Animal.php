<?php
/*
TODO:
move methods
*/
abstract class Animal extends Creature implements Ageable, Breedable{
	public function isBaby(){
		return $this->data["IsBaby"];
	}
	public function getMetadata(){
		$d = parent::getMetadata();
		if(!isset($this->data["IsBaby"])){
			$this->data["IsBaby"] = 0;
		}
		$d[14]["value"] = $this->isBaby();
		return $d;
	}
	public function environmentUpdate(){
		if($this->server->api->getProperty("spawn-animals") !== true){
			$this->close();
			return false;
		}
		parent::environmentUpdate();
	}
}