<?php
/**
 * A Tempt but for Monsters
 */
class TaskAttackPlayer extends TaskTempt
{
	public $attackTime = 0;
	public function onStart(EntityAI $ai)
	{
		$this->selfCounter = 1;
	}
	public function onUpdate(EntityAI $ai)
	{
		if(($this->target instanceof Entity && !$this->target->isPlayer()) || $this->target->distanceSquared($ai->entity) > 100 || $this->target->level->getName() != $ai->entity->level->getName()){
			$this->reset();
			return;
		}
		
		$ai->mobController->moveTo($this->target->x, floor($ai->entity->y), $this->target->z);
		$ai->mobController->lookOn($this->target);
		if($ai->entity->boundingBox->intersectsWith($this->target->boundingBox) && $this->attackTime <= 0){
			$ai->entity->attackEntity($this->target);
			$this->attackTime = 20;
		}
		--$this->attackTime;
		
	}
	public function canBeExecuted(EntityAI $ai)
	{
		$target = $this->findTarget($ai->entity, 10);
		if($target instanceof Entity && $target->class === ENTITY_PLAYER && $target->isPlayer()){
			$this->target = $target;
			return true;
		}
		
		return false;
	}
}

