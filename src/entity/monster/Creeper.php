<?php
class Creeper extends Monster{
	const TYPE = MOB_CREEPER;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 16, "generic");
		$this->setName("Creeper");
		$this->setSize(0.6, 1.7);
		$this->update();
		if($this->data["Saddled"] === 1){
			$this->server->schedule(30, [$this, "updateFuse"], []); //unknown ticks
		}
	}
	
	public function getMetadata(){
		$d = parent::getMetadata();
		if(!isset($this->data["Saddled"])){
			$this->data["Saddled"] = 0;
		}
		$d[16]["value"] = ((int)$this->data["Saddled"]);
		return $d;
	}
	
	public function updateFuse(){
		if($this->closed === true){
			return false;
		}
		if($this->type === MOB_CREEPER){
			$this->updateMetadata();
			$this->close();
			$explosion = new Explosion($this, 3);
			$explosion->explode();
		}
	}
	
	public function getDrops(){
		return $this->data["Saddled"] === 1 ? parent::getDrops() : [
			[GUNPOWDER, 0, mt_rand(0,2)]
		];
	}
}