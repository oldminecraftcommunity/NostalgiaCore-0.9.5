<?php
class Monster extends Creature{
	public function environmentUpdate(){
		parent::environmentUpdate();
		if($this->server->api->getProperty("spawn-mobs") !== true){
			$this->close();
			return false;
		}
	}
}