<?php

class TaskLookAtPlayer extends TaskBase{
	const S_LOOK = 0x1;
	const S_STOPLOOK = 0x2;
	public $target = false;
	private $nextExecCounter = 0;
	private $state, $yaw, $pitch;
	public function canBeExecuted(EntityAI $ai){
	    return !$ai->entity->isMoving() && --$this->nextExecCounter <= 0 && !@$ai->getTask("TaskLookAround")->wasExecuted && mt_rand(0,5) === 0 && Utils::randomFloat() >= 0.02;
	}

	protected function findTarget($e, $r){
		$ents = $e->server->api->entity->getRadius($e, $r, ENTITY_PLAYER); //TODO sort by nearest and select nearest
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
		$this->selfCounter = mt_rand(20, 40);
	}

	public function onUpdate(EntityAI $ai){
		if(!($this->target instanceof Entity)){
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
		$this->nextExecCounter = mt_rand(100, 200);
		$ai->entity->pitch = 0;
	}
}

