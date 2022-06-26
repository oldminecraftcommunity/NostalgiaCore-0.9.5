<?php

class Arrow extends Projectile{
	const TYPE = OBJECT_ARROW;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->server->schedule(1210, array($this, "update")); //Despawn
		$this->update();
	}
	
	public function environmentUpdate(){
		parent::environmentUpdate();
		$time = microtime(true);
		if(($time - $this->spawntime) >= 60){
			$this->close();
			return false;
		}
	}
	
	public function spawn($player){
		if($this->type === OBJECT_ARROW){
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
}