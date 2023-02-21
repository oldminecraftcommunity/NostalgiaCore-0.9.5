<?php

class Enderman extends Monster
{
	const TYPE = MOB_ENDERMAN;
	
	public $forceTeleport;
	
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 2.9);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setName("Enderman");
		$this->setSpeed(0.3);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 40, "generic");
	}
	
	public function harm($dmg, $cause = "generic", $force = false){
		parent::harm($dmg, $cause, $force);
		if($cause === "water"){
			$this->randomTeleport();
		}
	}
	
	public function randomTeleport(){
		$x = $this->x + ($this->random->nextFloat() - 0.5) * 64;
		$z = $this->z + ($this->random->nextFloat() - 0.5) * 64;
		for($y = 0; $y < 128; ++$y){
			$b = $this->level->getBlockWithoutVector($x, $y, $z);
			if($b instanceof Block && !$b->isTransparent){ //TODO hitbox check
				$this->x = $x;
				$this->y = $y+0.5;
				$this->z = $z;
			}
		}
	}
	
}

