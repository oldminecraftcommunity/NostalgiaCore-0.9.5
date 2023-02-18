<?php

class TaskRandomWalk extends TaskBase
{
	private $x, $z;
	public function onStart(EntityAI $ai)
	{
		$this->x = mt_rand(-16, 16);
		$this->z = mt_rand(-16, 16);
		if($this->x === 0 && $this->z === 0){
			$this->reset();
			return false;
		}
		$this->selfCounter = floor(5 * Utils::distance($ai->entity, $ai->entity->add($this->x, 0, $this->z)));
	}

	public function onEnd(EntityAI $ai)
	{
		$this->x = $this->z = 0;
	}

	public function onUpdate(EntityAI $ai)
	{
		if(($ai->entity instanceof Creeper && $ai->entity->isIgnited()) || $ai->isStarted("TaskTempt")) {
			$this->reset();
			return false; //TODO Better way: block movement 
		}
		--$this->selfCounter;
		$ai->mobController->moveNonInstant($this->x, 0, $this->z);
	}

	public function canBeExecuted(EntityAI $ai)
	{
		if(($ai->entity instanceof Creeper && $ai->entity->isIgnited()) || $ai->entity->hasPath() || $ai->isStarted("TaskTempt")) {
			return false;
		}
		return !$ai->entity->inPanic && !$ai->isStarted("TaskLookAround") && !$ai->isStarted("TaskLookAtPlayer") && mt_rand(0, 120) == 0;
	}

	
}
