<?php

class TaskLookAround extends TaskBase
{
	private $rotation;
	public function onStart(EntityAI $ai)
	{
		$this->selfCounter = 1;
		$this->rotation = mt_rand(-120, 120);
	}

	public function onEnd(EntityAI $ai)
	{
		$ai->entity->idleTime = mt_rand(20, 40);
	}

	public function canBeExecuted(EntityAI $ai)
	{
		return !$ai->entity->inPanic && !$ai->entity->isMoving() && lcg_value() < 0.02 && !$ai->isStarted("TaskLookAtPlayer") && !$ai->isStarted("TaskTempt") && !$ai->entity->hasPath(); /*Vanilla value*/
	}

	public function onUpdate(EntityAI $ai)
	{
		if($this->rotation === 0){
			$this->selfCounter = 0;
		}
		$v = min(Utils::getSign($this->rotation) * 10, $this->rotation);
		$ai->entity->headYaw += $v;
		$this->rotation -= $v;
		
	}
}
