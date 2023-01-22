<?php

class TaskTempt extends TaskBase
{
	public $target = false;
	
	public function onStart(EntityAI $ai)
	{
		$this->selfCounter = 1;
	}

	public function onEnd(EntityAI $ai)
	{
		unset($this->target);
		$ai->entity->pitch = 0;
	}

	public function onUpdate(EntityAI $ai)
	{
		if(($this->target instanceof Entity && !$this->target->isPlayer()) || $this->target->distanceSquared($ai->entity) > 100 || !$ai->entity->isFood($this->target->player->getHeldItem()->getID()) || $this->target->level->getName() != $ai->entity->level->getName()){
			$this->reset();
			return;
		}
		
		$ai->mobController->moveTo($this->target->x, floor($ai->entity->y), $this->target->z);
		
		$ai->mobController->lookOn($this->target);
	}

	public function canBeExecuted(EntityAI $ai)
	{
		if(!($ai->entity instanceof Breedable)){ //TODO Work with path
			return false;
		}
		$target = $this->findTarget($ai->entity, 10);
		if($target instanceof Entity && $target->class === ENTITY_PLAYER && $target->isPlayer() && $ai->entity->isFood($target->player->getHeldItem()->getID())){
			$this->target = $target;
			return true;
		}
		
		return false;
	}
	
	protected function findTarget($e, $r){
		$svd = null;
		$svdDist = -1;
		foreach($e->server->api->entity->getRadius($e, $r * 3, ENTITY_PLAYER) as $p){
			if($svdDist === -1){
				$svdDist = Utils::manh_distance($e, $p);
				$svd = $p;
				continue;
			}
			if($svd != null && $svdDist === 0){
				$svd = $p;
			}
			
			if(($cd = Utils::manh_distance($e, $p)) < $svdDist){
				$svdDist = $cd;
				$svd = $p;
			}
		}
		
		if($svd == null || Utils::distance_noroot($e, $svd) > ($r * $r)){
			return null;
		}
		
		return $svd;
	}
}

