<?php
class PigZombie extends Monster{
	const TYPE = MOB_PIGMAN;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.3, 1.95);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 12, "generic");
		$this->setName("Pigman");
		$this->setSpeed(0.25);
		$this->update();
	}
	public function getAttackDamage(){
		return 5;
	}
	public function getDrops(){
		return [
			[COOKED_PORKCHOP, 0, mt_rand(0,2)],
			[GOLD_INGOT, 0, mt_rand(0,1)]
		];
	}
	
	public function harm($dmg, $cause = "generic", $force = false)
	{
		if($cause === "fire" || $cause === "lava" || $cause === "burning"){
			return false;
		}
		return parent::harm($dmg, $cause, $force);
	}
}