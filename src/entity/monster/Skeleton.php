<?php
class Skeleton extends Monster{
	const TYPE = MOB_SKELETON;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 1.99);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 10, "generic");
		$this->setName("Skeleton");
		$this->ai->removeTask("TaskAttackPlayer");
		$this->setSpeed(0.25);
		$this->update();
	}
	
	public function getAttackDamage(){
		return 0; //TODO special attack
	}
	
	public function updateBurning(){
		if($this->fire > 0 or !$this->level->isDay()){
			return false;
		}
		
		for($y = $this->y; $y < 129; $y++){
			$block = $this->level->getBlockWithoutVector($this->x, $y, $this->z);
			if($block->isSolid){
				return false;
			}
		}
		if($block->getID() === AIR){
			$this->fire = 160; //Value from 0.8.1
			$this->updateMetadata();
			return true;
		}else{
			return false;
		}
	}
	
	public function update(){
		$this->updateBurning();
		parent::update();
	}
	
	public function getDrops(){
		return [
			[ARROW, 0, mt_rand(0,2)],
			[BONE, 0, mt_rand(0,2)]
		];
	}
}