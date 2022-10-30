<?php

class PrimedTNT extends Entity{
	const TYPE = OBJECT_PRIMEDTNT;
	const CLASS_TYPE = ENTITY_OBJECT;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		if(!isset($this->data["fuse"])){
			$this->data["fuse"] = 0;
		}
		$this->setHealth(10000000, "generic");
		$this->server->schedule(5, [$this, "updateFuse"], [], true);
		$this->update();
	}
	
	public function getMetadata(){
		$d = parent::getMetadata();
		$d[16]["value"] = (int) max(0, $this->data["fuse"] - (microtime(true) - $this->spawntime) * 20);
		return $d;
	}
	
	public function updateFuse(){
		if($this->closed === true){
			return false;
		}
		if($this->type === OBJECT_PRIMEDTNT){
			$this->updateMetadata();
			if(((microtime(true) - $this->spawntime) * 20) >= $this->data["fuse"]){
				$this->close();
				$explosion = new Explosion($this, $this->data["power"]);
				$explosion->explode();
			}
		}
	}
	
	public function spawn($player){
		$pk = new AddEntityPacket;
		$pk->eid = $this->eid;
		$pk->type = $this->type;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->did = 0;		
		$player->dataPacket($pk);
		$pk = new SetEntityMotionPacket;
		$pk->eid = $this->eid;
		$pk->speedX = $this->speedX;
		$pk->speedY = $this->speedY;
		$pk->speedZ = $this->speedZ;
		$player->dataPacket($pk);
	}
}