<?php
class Monster extends Creature{
	public function environmentUpdate(){
		$upd = parent::environmentUpdate();
		if($this->server->api->getProperty("spawn-mobs") !== true){
			$this->close();
			return false;
		}
		
		return $upd;
	}
}