<?php

class TaskLookAtPlayer extends TaskBase{
	const S_LOOK = 0x1;
	const S_STOPLOOK = 0x2;
	public $target = false;
	private $state, $yaw, $pitch;
	public function canBeExecuted(EntityAI $ai){
		return Utils::randomFloat() < 0.02 && !$ai->entity->isMoving() && !$ai->isStarted("TaskLookAround") && !$ai->isStarted("TaskTempt");
	}

	protected function findTarget($e, $r){
		$svd = null;
		$svdDist = -1;
		foreach($e->server->api->entity->getRadius($e, $r, ENTITY_PLAYER) as $p){
			if($svdDist === -1){
				$svdDist = Utils::manh_distance($e, $p);
				$svd = $p;
				continue;
			}
			if($svd != null && $svdDist === 0){
				$svd = $p;
			}
			
			if(($cd = Utils::manh_distance($e, $p)) < $svdDist){
				$svdDist = $cd;
				$svd = $p;
			}
		}
		return $svd;
	}

	public function onStart(EntityAI $ai){
		$this->target = $this->findTarget($ai->entity, 6); //TODO max distance for different mobs
		if(!($this->target instanceof Entity) || !$this->target->isPlayer()){
			$this->reset();
			return;
		}
		$this->yaw = $ai->entity->yaw;
		$this->pitch = $ai->entity->pitch;
		$this->selfCounter = mt_rand(20, 60);
	}

	public function onUpdate(EntityAI $ai){
		if(!($this->target instanceof Entity) || Utils::distance($ai->entity, $this->target) > 6){ //TODO max distance for different mobs
			$this->reset();
			return;
		}
		$ai->mobController->lookOn($this->target);
		$pk = new RotateHeadPacket(); //TODO headYaw auto update
		$pk->eid = $ai->entity->eid;
		$pk->yaw = $ai->entity->yaw;
		$ai->entity->server->api->player->broadcastPacket($ai->entity->level->players, $pk);
		$this->selfCounter--;
	}

	public function onEnd(EntityAI $ai){
		unset($this->target);
		$ai->entity->pitch = 0;
	}
}

