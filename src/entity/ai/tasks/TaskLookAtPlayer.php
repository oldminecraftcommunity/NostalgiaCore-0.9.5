<?php

class TaskLookAtPlayer extends TaskBase{
	public $target = false;
	public $distance;
	public function __construct($distance){
		$this->distance = $distance;
	}
	
	public function canBeExecuted(EntityAI $ai){
		return !$ai->entity->inPanic && lcg_value() < 0.02 && !$ai->entity->isMovingHorizontally() && !$ai->isStarted("TaskMate") && !$ai->isStarted("TaskLookAround") && !$ai->isStarted("TaskTempt")  && !$ai->isStarted("TaskPanic") && !$ai->entity->hasPath();
	}

	protected function findTarget(Creature $e, $r){
		return $e->closestPlayerDist > $r*$r ? null : $e->level->entityList[$e->closestPlayerEID];
	}

	public function onStart(EntityAI $ai){
		$this->target = $this->findTarget($ai->entity, $this->distance);
		if(!($this->target instanceof Entity) || !$this->target->isPlayer()){
			$this->reset();
			$this->onEnd($ai);
			return;
		}
		
		$this->selfCounter = mt_rand(20, 60);
	}

	public function onUpdate(EntityAI $ai){
		if(!($this->target instanceof Entity) || Utils::distance($ai->entity, $this->target) > 6 || $this->target->level->getName() != $ai->entity->level->getName()){ //TODO max distance for different mobs
			$this->reset();
			$this->onEnd($ai);
			return;
		}
		$ai->mobController->setLookPosition($this->target->x, $this->target->y + $this->target->getEyeHeight(), $this->target->z, 10, $ai->entity->getVerticalFaceSpeed());
		$ai->mobController->lookOn($this->target);
		$this->selfCounter--;
	}
	
	public function onEnd(EntityAI $ai){
		unset($this->target);
		$ai->entity->pitch = 0;
		$ai->entity->sendMoveUpdate();
	}
}

