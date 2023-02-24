<?php

class Enderman extends Monster
{
	const TYPE = MOB_ENDERMAN;
	
	const DATA_BLOCKID = 16;
	const DATA_BLOCKMETA = 17;
	const DATA_ANGRY = 18;
	public $forceTeleport;
	
	protected $isAngry;
	
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 2.9);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setName("Enderman");
		$this->setSpeed(0.3);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 40, "generic");
	}
	
	public function getMetadata(){
		$ret = parent::getMetadata();
		$ret[self::DATA_ANGRY] = ["type" => 0, "value" => (int)$this->isAngry];
		$ret[self::DATA_BLOCKID] = ["type" => 1, "value" => 0];
		$ret[self::DATA_BLOCKMETA] = ["type" => 1, "value" => 0]; //TODO carry blocks
		return $ret;
	}
	
	public function setAngry($t){
		if($this->isAngry != $t){
			$this->isAngry = $t;
			$this->updateMetadata();
		}
	}
	
	public function isAngry(){
		return $this->isAngry;
	}
	
	public function harm($dmg, $cause = "generic", $force = false){
		parent::harm($dmg, $cause, $force);
		if($cause === "water"){
			$this->randomTeleport();
		}
		if(is_numeric($cause) && $this->level->entityList[$cause]->isPlayer()){
			$this->setAngry(true); //TODO better way to find is it angry or not
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

