<?php
/*
TODO:
move methods
*/
abstract class Creature extends Living{
	const CLASS_TYPE = ENTITY_MOB;
	
	public $inPanic;
	
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->inPanic = false; //force for now
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 1, "generic");
		// $this->setName((isset($mobs[$this->type]) ? $mobs[$this->type]:$this->type));
		$this->ai->addTask(new TaskLookAround());
		$this->ai->addTask(new TaskRandomWalk());
		$this->ai->addTask(new TaskLookAtPlayer());
		$this->ai->addTask(new TaskSwimming());
	}
	
	public function createSaveData(){
		$data = parent::createSaveData();
		$data["State"] = @$this->getState();
		return $data;
	}
	
	public function getSpeedModifer(){
		return $this->speedModifer * ($this->inPanic ? 1.4 : 0.7);
	}
	public function getArmorValue(){
		return 2;
	}
	public function spawn($player){
		if(!($player instanceof Player)){
			$player = $this->server->api->player->get($player);
		}
		if($player->eid === $this->eid or $this->closed !== false or ($player->level !== $this->level and $this->class !== ENTITY_PLAYER)){
			return false;
		}
		$pk = new AddMobPacket;
		$pk->eid = $this->eid;
		$pk->type = $this->type;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->getMetadata();				
		$player->dataPacket($pk);
				
		$pk = new SetEntityMotionPacket;
		$pk->eid = $this->eid;
		$pk->speedX = $this->speedX;
		$pk->speedY = $this->speedY;
		$pk->speedZ = $this->speedZ;
		$player->dataPacket($pk);
	}
	
}
