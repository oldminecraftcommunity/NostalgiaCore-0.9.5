<?php

class Chicken extends Animal{
	const TYPE = MOB_CHICKEN;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		console("A constructor which indicates it works! ".":".$eid.":".$class.":".$type);
		parent::__construct($level, $eid, $class, $type, $data);
		$server = ServerAPI::request();
		$server->schedule(mt_rand(0,6000) + 6000, array($this, "dropAnEgg"));
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:4, "generic");
		$this->update();
		//$this->setName('Chicken');
		$this->size = $this->isBaby() ? 0.35 : 0.7;
	}
	
	public function dropAnEgg(){
		ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem(EGG,0,1));
		$this->server->schedule(mt_rand(0,6000) + 6000, array($this, "dropAnEgg"));
	}
}