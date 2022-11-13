<?php

class Chicken extends Animal{
	const TYPE = MOB_CHICKEN;
	public $timeUntilEgg;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 4, "generic");
		$this->setName('Chicken');
		$this->setSize($this->isBaby() ? 0.2 : 0.4, $this->isBaby() ? 0.35 : 0.7);
		$this->setSpeed(0.25);
		$this->timeUntilEgg = mt_rand(0,6000) + 6000;
		$this->update();
	}
	public function isFood($id){
		return $id === PUMPKIN_SEEDS || $id === MELON_SEEDS || $id === BEETROOT_SEEDS || $id === WHEAT_SEEDS;
	}
	
	public function update(){
	    parent::update();
	    if($this->timeUntilEgg-- <= 0 && !$this->isBaby()){
	        $this->dropAnEgg();
	        $this->timeUntilEgg = mt_rand(0,6000) + 6000;
	    }
	}
	
	public function dropAnEgg(){
		if($this->closed){
			return;
		}
		ServerAPI::request()->api->entity->drop(new Position($this->x + 0.5, $this->y, $this->z + 0.5, $this->level), BlockAPI::getItem(EGG, 0, 1));
	}
	
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : [
			[FEATHER, 0, mt_rand(0,2)],
			[[$this->fire > 0 ? COOKED_CHICKEN : RAW_CHICKEN], 0, 1]
		];
	}

}