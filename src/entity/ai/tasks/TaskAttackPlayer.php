<?php

class TaskAttackPlayer extends TaskBase
{
	public $speedMultiplier;
	public $rangeSquared;
	
	public $attackCounter;
	
	public function __construct($speed, $range){
		$this->speedMultiplier = $speed;
		$this->rangeSquared = $range*$range;
	}
	
	public function onStart(EntityAI $ai)
	{
		$this->selfCounter = 1;
	}
	
	
	public function onUpdate(EntityAI $ai)
	{
		if(!$this->isTargetValid($ai)){
			$this->reset();
			$this->onEnd($ai);
			return false;
		}
		$ai->mobController->setMovingTarget($ai->entity->target->x, $ai->entity->target->y, $ai->entity->target->z, $this->speedMultiplier);
		$ai->mobController->setLookPosition($ai->entity->target->x, $ai->entity->target->y + 0.12, $ai->entity->target->z, 10, $ai->entity->getVerticalFaceSpeed());
		
		--$this->attackCounter;
		$v1 = $ai->entity->width * $ai->entity->width * 4;
		if($ai->entity instanceof Creeper){
			$v1 = 9;
		}
		$e = $ai->entity;
		$t = $e->target;
		$xDiff = ($t->x - $e->x);
		$yDiff = ($t->y - $e->y);
		$zDiff = ($t->z - $e->z);
		$dist = ($xDiff*$xDiff + $yDiff*$yDiff + $zDiff*$zDiff);
		if($dist <= $v1){
			if($this->attackCounter <= 0){
				 $this->attackCounter = $e->attackEntity($t, sqrt($dist)) ? 20 : 0;
			}
		}
		
	}
	
	
	public function isTargetValid(EntityAI $ai){
		$e = $ai->entity;
		if($e->target instanceof Entity && !$e->target->closed && !$e->target->dead){
			$t = $e->target;
			$xDiff = ($t->x - $e->x);
			$yDiff = ($t->y - $e->y);
			$zDiff = ($t->z - $e->z);
			return ($xDiff*$xDiff + $yDiff*$yDiff + $zDiff*$zDiff) <= $this->rangeSquared;
		}
		return false;
	}
	
	public function tryTargeting(EntityAI $ai){
		$e = $ai->entity;
		if($e->target instanceof Entity){
			$t = $e->target;
			$xDiff = ($t->x - $e->x);
			$yDiff = ($t->y - $e->y);
			$zDiff = ($t->z - $e->z);
			if(($xDiff*$xDiff + $yDiff*$yDiff + $zDiff*$zDiff) <= $this->rangeSquared){
				return true;
			}
		}
		
		$closestTarget = $e->closestPlayerToAttackDist <= $this->rangeSquared ? $e->level->entityList[$e->closestPlayerToAttackEID] : null;
		
		if($closestTarget != null){
			$e->target = $closestTarget; //TODO dont save entity object ?
			return true;
		}
		return false;
	}
	
	public function canBeExecuted(EntityAI $ai)
	{
		return $this->tryTargeting($ai);
	}
	
	public function onEnd(EntityAI $ai)
    {
		$ai->entity->target = false;
	}

}

