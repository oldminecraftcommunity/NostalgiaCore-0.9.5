<?php
class Zombie extends Monster{
	const TYPE = MOB_ZOMBIE;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		$this->setSize(0.6, 1.85);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 12, "generic");
		$this->setName("Zombie");
		$this->setSpeed(0.23);
		
		$this->ai->addTask(new TaskRandomWalk(1.0));
		$this->ai->addTask(new TaskLookAround());
		$this->ai->addTask(new TaskSwimming());
		$this->ai->addTask(new TaskAttackPlayer(1.0, 16));
	}
	
	public function getArmorValue(){
		return 2;
	}
	
	public function updateBurning(){
		if($this->fire > 0 || !$this->level->isDay() || $this->inWater){ //TODO fix burning in water
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
	
	public function getAttackDamage(){
		return 4;
	}
	
	public function update($now){
		$this->updateBurning();
		parent::update($now);
	}
	
	public function getDrops(){
		return [
			[CARROT, 0, Utils::chance(0.83) ? 1 : 0],
			[POTATO, 0, Utils::chance(0.83) ? 1 : 0],
			[FEATHER, 0, mt_rand(0,2)]
		];
	}
}