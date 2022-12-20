<?php

class TaskLookAtPlayer extends TaskBase{
	const S_LOOK = 0x1;
	const S_STOPLOOK = 0x2;
	public $target = false;
	private $state, $yaw, $pitfh;
	public function canBeExecuted(EntityAI $ai){
		return !@$ai->getTask("TaskLookAround")->wasExecuted && mt_rand(0,5) === 0;
	}

	protected function findTarget($e, $r){
		$ents = $e->server->api->entity->getRadius($e, $r, ENTITY_PLAYER);
		
		return count($ents) <= 0 ? false : $ents[array_rand($ents)];
	}

	public function onStart(EntityAI $ai){
		$this->target = $this->findTarget($ai->entity, 5);
		if(!($this->target instanceof Entity) || !$this->target->isPlayer()){
			$this->reset();
			return;
		}
		$this->yaw = $ai->entity->yaw;
		$this->pitch = $ai->entity->pitch;
		$this->selfCounter = mt_rand(40, 120) + 40; /*last 40 = return back*/
	}

	public function onUpdate(EntityAI $ai){
		if(!($this->target instanceof Entity)){
			$this->reset();
			return;
		} //TODO MobController lookAt method
		$dx = $this->target->x - $ai->entity->x;
		$dy = ($ai->entity->y + $ai->entity->height) - ($this->target->y + 1.62);
		$dz = $this->target->z - $ai ->entity->z;
		$diff = sqrt($dx * $dx + $dz * $dz);
		if($diff === 0){
			return;
		}
		$tan = 90 - rad2deg(atan($dx / $dz));
		$thetaOffset = $dz < 0 ? 45 : 180;
		$calcYaw = $tan + $thetaOffset;
		$calcPitch = rad2deg(atan($dy / $diff));
		$ai->entity->yaw = $calcYaw;
		$ai->entity->pitch = $calcPitch;
		$pk = new RotateHeadPacket();
		$pk->eid = $ai->entity->eid;
		$pk->yaw = $calcYaw;
		$ai->entity->server->api->player->broadcastPacket($ai->entity->level->players, $pk);
		$this->selfCounter--;
	}

	public function onEnd(EntityAI $ai){
		unset($this->target);
	}
}

