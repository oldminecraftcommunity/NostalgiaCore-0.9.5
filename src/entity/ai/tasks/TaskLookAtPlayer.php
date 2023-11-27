<?php

class TaskLookAtPlayer extends TaskBase{
	public $target = false;
	private $state, $yaw, $pitch;
	public function canBeExecuted(EntityAI $ai){
		return !$ai->entity->inPanic && lcg_value() < 0.02 && !$ai->entity->isMovingHorizontally() && !$ai->isStarted("TaskLookAround") && !$ai->isStarted("TaskTempt") && !$ai->entity->hasPath();
	}

	protected function findTarget($e, $r){
		$svd = null;
		$svdDist = -1;
		foreach($e->level->players as $p){
			$p = $p->entity;
			if(Utils::distance_noroot($e, $p) > $r*$r){
				continue;
			}
			if($svdDist === -1){
				$svdDist = Utils::distance_noroot($e, $p);
				$svd = $p;
				continue;
			}
			if($svd != null && $svdDist === 0){
				$svd = $p;
			}
			if(($cd = Utils::distance_noroot($e, $p)) < $svdDist){
				$svdDist = $cd;
				$svd = $p;
			}
		}
		
		if($svd == null){
			return null;
		}
		
		return $svd;
	}

	public function onStart(EntityAI $ai){
		$this->target = $this->findTarget($ai->entity, 6); //TODO max distance for different mobs
		if(!($this->target instanceof Entity) || !$this->target->isPlayer()){
			$this->reset();
			$this->onEnd($ai);
			return;
		}
		$this->yaw = $ai->entity->yaw;
		$this->pitch = $ai->entity->pitch;
		$this->selfCounter = mt_rand(20, 60);
	}

	public function onUpdate(EntityAI $ai){
		if(!($this->target instanceof Entity) || Utils::distance($ai->entity, $this->target) > 6 || $this->target->level->getName() != $ai->entity->level->getName()){ //TODO max distance for different mobs
			$this->reset();
			$this->onEnd($ai);
			return;
		}
		$ai->mobController->lookOn($this->target);
		$this->selfCounter--;
	}
	
	public function onEnd(EntityAI $ai){
		unset($this->target);
		$ai->entity->pitch = 0;
	}
}

