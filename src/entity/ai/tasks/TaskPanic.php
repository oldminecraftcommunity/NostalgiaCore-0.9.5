<?php

class TaskPanic extends TaskBase
{
	protected $randX = 2, $randZ = 2;
	
	public $speedMultiplier;
	public function __construct($speedMultiplier){
		$this->speedMultiplier = $speedMultiplier;
	}
	
	public function onStart(EntityAI $ai)
	{
		$this->selfCounter = 60;
		$this->regenerateRandXZ();
	}

	public function onEnd(EntityAI $ai)
	{
		$ai->entity->inPanic = false;
		$this->reset();
	}
	
	public function regenerateRandXZ(){
		$this->randX = (mt_rand(0, 1) ? -1 : 1);
		$this->randZ = (mt_rand(0, 1) ? -1 : 1);
	}
	
	public function reset(){
		$this->randX = $this->randZ = 2;
	}
	
	public function onUpdate(EntityAI $ai)
	{
		--$this->selfCounter;
		if($this->selfCounter % 20 === 0) $this->regenerateRandXZ();
		$ai->mobController->setMovingOffset($this->randX, 0, $this->randZ, $this->speedMultiplier);
	}

	public function canBeExecuted(EntityAI $ai)
	{
		return $ai->entity instanceof Animal && $ai->entity->inPanic && $ai->entity->knockbackTime <= 0;
	}

	
}

