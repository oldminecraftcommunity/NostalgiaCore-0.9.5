<?php
/*
TODO:
move methods
*/
class Animal extends Creature implements Ageable{
	public function isBaby(){
		return $this->data["isBaby"];
	}
}