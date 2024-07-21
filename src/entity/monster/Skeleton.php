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
		
		$this->ai->addTask(new TaskRandomWalk(1.0));
		$this->ai->addTask(new TaskLookAround());
		$this->ai->addTask(new TaskSwimming());
		$this->ai->addTask(new TaskRangedAttack(1.0, 16));
	}
	
	public function getAttackDamage(){
		return 0;
	}
	
	public function updateBurning(){
		if($this->fire > 0 or !$this->level->isDay() || $this->inWater){ //TODO fix burning in water
			return false;
		}
		
		for($y = $this->y; $y < 129; $y++){
			$block = $this->level->level->getBlockID($this->x, $y, $this->z);
			if(StaticBlock::getIsSolid($block)){
				return false;
			}
		}
		if($block === AIR){
			$oldFire = $this->fire;
			$this->fire = 160; //Value from 0.8.1
			if(($oldFire > 0 && $this->fire <= 0) || ($oldFire <= 0 && $this->fire > 0)){
				$this->updateMetadata(); //TODO rewrite metadata
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function update($now){
		$this->updateBurning();
		parent::update($now);
	}
	
	public function getDrops(){
		return [
			[ARROW, 0, mt_rand(0,2)],
			[BONE, 0, mt_rand(0,2)]
		];
	}
}