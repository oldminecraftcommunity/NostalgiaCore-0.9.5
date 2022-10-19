<?php
/*
TODO:
move methods
*/
abstract class Creature extends Living{
	const CLASS_TYPE = ENTITY_MOB;
	public $moveTime;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:1, "generic");
		//$this->setName((isset($mobs[$this->type]) ? $mobs[$this->type]:$this->type));
		$this->width = 1;
		$this->moveTime = 0;
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