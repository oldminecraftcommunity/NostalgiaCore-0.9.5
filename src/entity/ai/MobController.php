<?php

class MobController
{
	/**
	 * @var Entity
	 */
	public $entity;
	
	public function __construct($e){
		$this->entity = $e;
	}
	
	public function moveNonInstant($x, $y, $z){
		if($x == 0 && $y == 0 && $z == 0){
			return false; //failed
		}
		
		$ox = ($x > 0 ? 1 : ($x < 0 ? -1 : 0));
		$oy = ($y > 0 ? 1 : ($y < 0 ? -1 : 0));
		$oz = ($z > 0 ? 1 : ($z < 0 ? -1 : 0));
		$this->entity->moveEntityWithOffset($ox, $oy, $oz);
		$this->faceEntity($this->entity->add($ox, $oy, $oz));
		$pk = new RotateHeadPacket(); //TODO headYaw auto update
		$pk->eid = $this->entity->eid;
		$pk->yaw = $this->entity->yaw;
		$this->entity->server->api->player->broadcastPacket($this->entity->level->players, $pk);
		return true;
	}
	
	public function moveTo($x, $y, $z){
		return $this->moveNonInstant($x - floor($this->entity->x), $y - floor($this->entity->y), $z - floor($this->entity->z));
	}
	
	public function faceEntity(Vector3 $v){
		$d = $v->subtract($this->entity)->normalize();
		$dx = $d->x;
		$dz = $d->z;
		
		$tan = $dz == 0 ? ($dx < 0 ? 180 : 0) : (90 - rad2deg($dx / $dz)); 
		$thetaOffset = $dz < 0 ? 90 : 270;
		$this->entity->yaw = $this->entity->headYaw = ($thetaOffset + $tan);
	}
	
	public function lookOffset($x, $y, $z, $pitch = true){
		$tan = $z == 0 ? ($x < 0 ? 180 : 0) : (90 - rad2deg(atan($x / $z))); /*arctan(infinity) = pi/2 = (90deg) - 90 = 0*/
		$thetaOffset = $z <= 0 ? 90 : 270;
		$calcYaw = $tan + $thetaOffset;
		$this->entity->yaw = $calcYaw;
		if($pitch){
			$diff = sqrt($x * $x + $z * $z);
			$calcPitch = rad2deg(atan($y / $diff));
			$this->entity->pitch = $this->entity->type === MOB_CHICKEN ? -$calcPitch : $calcPitch;
		}
		
		$this->entity->server->query("UPDATE entities SET pitch = ".$this->entity->pitch.", yaw = ".$this->entity->yaw." WHERE EID = ".$this->entity->eid.";");
		return true;
	}
	
	public function lookOn($x, $y = 0, $z = 0, $pitch = true){
		if($x instanceof Vector3){
			return $this->lookOn($x->x, $x->y + $x->getEyeHeight(), $x->z, $pitch);
		}
		return $this->lookOffset($x - $this->entity->x, ($this->entity->y + $this->entity->height) - $y, $z - $this->entity->z, $pitch);
	}
	
	public function __destruct(){
		unset($this->entity);
	}
}

