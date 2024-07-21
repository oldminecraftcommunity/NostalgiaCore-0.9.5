<?php

class TaskLookAround extends TaskBase
{
	public $lookOffsetX, $lookOffsetZ;
	
	public function onStart(EntityAI $ai)
	{
		$this->selfCounter = 20 + lcg_value();
		$v = (M_PI * 2) * lcg_value();
		$this->lookOffsetX = cos($v);
		$this->lookOffsetZ = sin($v);
	}

	public function onEnd(EntityAI $ai)
	{
		//$ai->entity->idleTime = mt_rand(20, 40);
	}

	public function canBeExecuted(EntityAI $ai)
	{
		return !$ai->entity->inPanic && !$ai->entity->isMoving() && lcg_value() < 0.02 && !$ai->isStarted("TaskLookAtPlayer") && !$ai->isStarted("TaskAttackPlayer")  && !$ai->isStarted("TaskMate")  && !$ai->isStarted("TaskTempt") && !$ai->entity->hasPath(); /*Vanilla value*/
	}
	
	public function onUpdate(EntityAI $ai)
	{
		--$this->selfCounter;
		$ai->mobController->setLookPosition($ai->entity->x + $this->lookOffsetX, $ai->entity->y + $ai->entity->getEyeHeight(), $ai->entity->z + $this->lookOffsetZ, 10, $ai->entity->getVerticalFaceSpeed());
	}
}
