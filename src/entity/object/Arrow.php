<?php

class Arrow extends Projectile{
	const TYPE = OBJECT_ARROW;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		//$this->server->schedule(1210, array($this, "update")); //Despawn
	}
	public function update(){
	    $now = microtime(true);
	    if(($now - $this->spawntime) >= 60){
	        $this->close();
	        return false;
	    }
		$f3 = 0.99;
		$f5 = 0.03;
		$this->move(new Vector3($this->speedX, $this->speedY, $this->speedZ));
		$this->speedX *= $f3;
		$this->speedZ *= $f3;
		$this->speedY -= $f5;
		$this->server->api->handle("entity.move", $this);
		$this->server->api->handle("entity.motion", $this);
		$this->handleUpdate();
		$this->server->schedule(1, array($this, "update"), false);
		$this->lastUpdate = $now;
	}
	public function handleUpdate(){
		$pk = new MoveEntityPacket_PosRot;
		$pk->eid = $this->eid;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$this->server->api->player->broadcastPacket($this->level->players, $pk);
	}
	public function shoot($d, $d1, $d2, $f, $f1){ //original name from 0.8.1 IDA decompilation, var names are taken from b1.7.3
		
		$f2 = sqrt($d * $d + $d1 * $d1 + $d2 * $d2);
        $d /= $f2;
        $d1 /= $f2;
        $d2 /= $f2;
        $d += $this->random->nextGaussian() * 0.0075 * $f1; //0.0074999998323619366 replaced with 0.0075
        $d1 += $this->random->nextGaussian() * 0.0075 * $f1;
        $d2 += $this->random->nextGaussian() * 0.0075 * $f1;
        $d *= $f;
        $d1 *= $f;
        $d2 *= $f;
        $this->speedX = $d;
        $this->speedY = $d1;
        $this->speedZ = $d2;
        $f3 = sqrt($d * $d + $d2 * $d2);
        $this->yaw = (atan2($d, $d2) * 180) / M_PI;
        $this->pitch = (atan2($d1, $f3) * 180) / M_PI;
		$this->update();
        //TODO i guess? $ticksInGround = 0;
	}
	public function spawn($player){
		if($this->type === OBJECT_ARROW){
			$pk = new AddEntityPacket;
			$pk->eid = $this->eid;
			$pk->type = $this->type;
			$pk->x = $this->x;
			$pk->y = $this->y;
			$pk->z = $this->z;
			$pk->did = 1;		
			$pk->speedX = $this->speedX;
			$pk->speedY = $this->speedY;
			$pk->speedZ = $this->speedZ;
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