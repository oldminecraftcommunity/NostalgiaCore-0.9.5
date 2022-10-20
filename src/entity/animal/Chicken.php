<?php

class Chicken extends Animal{
	const TYPE = MOB_CHICKEN;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->server->schedule(mt_rand(0,6000) + 6000, array($this, "dropAnEgg"));
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 4, "generic");
		$this->setName('Chicken');
		$this->setSize($this->isBaby() ? 0.2 : 0.4, $this->isBaby() ? 0.35 : 0.7);
		$this->update();
	}
	public function isFood($id){
		return $id === PUMPKIN_SEEDS || $id === MELON_SEEDS || $id === BEETROOT_SEEDS || $id === WHEAT_SEEDS;
	}
	public function dropAnEgg(){
		if($this->closed){
			return;
		}
		ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem(EGG,0,1));
		$this->server->schedule(mt_rand(0,6000) + 6000, array($this, "dropAnEgg"));
	}
	
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : 
		array(
			array(FEATHER, 0, mt_rand(0,2)),
			array(($this->fire > 0 ? COOKED_CHICKEN : RAW_CHICKEN), 0, 1),
		);
	}
}