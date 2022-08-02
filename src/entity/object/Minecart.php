<?php

class Minecart extends Vehicle{
	const TYPE = OBJECT_MINECART;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->x = isset($this->data["TileX"]) ? $this->data["TileX"]:$this->x;
		$this->y = isset($this->data["TileY"]) ? $this->data["TileY"]:$this->y;
		$this->z = isset($this->data["TileZ"]) ? $this->data["TileZ"]:$this->z;
		$this->setHealth(1, "generic");
		//$this->setName((isset($objects[$this->type]) ? $objects[$this->type]:$this->type));
		$this->size = 1;
		
		$this->update();
	}
	
	public function getDrops(){
		return array(
			array(MINECART, 0, 1),
		);
	}
	
	public function spawn($player){
		$pk = new AddEntityPacket;
		$pk->eid = $this->eid;
		$pk->type = $this->type;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$player->dataPacket($pk);
					
		$pk = new SetEntityMotionPacket;
		$pk->eid = $this->eid;
		$pk->speedX = $this->speedX;
		$pk->speedY = $this->speedY;
		$pk->speedZ = $this->speedZ;
		$player->dataPacket($pk);
	}
}