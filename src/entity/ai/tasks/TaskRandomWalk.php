<?php

class TaskRandomWalk extends TaskBase
{
	private $x, $z;
	public $speedMultiplier;
	public function __construct($speedMultiplier){
		$this->speedMultiplier = $speedMultiplier;
	}
	
	public function onStart(EntityAI $ai)
	{
		$this->x = mt_rand(-1, 1);
		$this->z = mt_rand(-1, 1);
		if($this->x === 0 && $this->z === 0){
			$this->reset();
			return false;
		}
		$this->selfCounter = mt_rand(80, 100);
	}

	public function onEnd(EntityAI $ai)
	{
		$this->x = $this->z = 0;
	}

	public function onUpdate(EntityAI $ai)
	{
		if(($ai->entity instanceof Creeper && $ai->entity->isIgnited()) || $ai->isStarted("TaskTempt") || $ai->isStarted("TaskFollowParent") || $ai->isStarted("TaskRangedAttack")) {
			$this->reset();
			return false; //TODO Better way: block movement
		}
		
		--$this->selfCounter;
		$ai->mobController->setMovingOffset($this->x, 0, $this->z, $this->speedMultiplier);
	}

	public function canBeExecuted(EntityAI $ai)
	{
		if(($ai->entity instanceof Creeper && $ai->entity->isIgnited()) || $ai->entity->hasPath() || $ai->isStarted("TaskTempt") || $ai->isStarted("TaskAttackPlayer") || $ai->isStarted("TaskRangedAttack")) {
			return false;
		} // i really need mutexBits
		return !$ai->entity->inPanic && !$ai->isStarted("TaskMate")  && !$ai->isStarted("TaskEatTileGoal") && !$ai->isStarted("TaskLookAround") && !$ai->isStarted("TaskFollowParent") && !$ai->isStarted("TaskLookAtPlayer") && mt_rand(0, 120) == 0;
	}

	
}
