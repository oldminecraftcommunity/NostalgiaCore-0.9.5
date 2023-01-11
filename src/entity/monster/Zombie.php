<?php
class Zombie extends Monster{
	const TYPE = MOB_ZOMBIE;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 12, "generic");
		$this->setName("Zombie");
		$this->setSize(0.6, 1.85);
		$this->setSpeed(0.23);
		$this->update();
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
			[CARROT, 0, Utils::chance(0.83) ? 1 : 0],
			[POTATO, 0, Utils::chance(0.83) ? 1 : 0],
			[FEATHER, 0, mt_rand(0,2)]
		];
	}
}