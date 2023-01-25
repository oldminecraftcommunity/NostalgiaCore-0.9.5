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
		if(!($this->target instanceof Entity) || ($ai->entity instanceof Spider && $ai->entity->level->isDay()) || ($this->target instanceof Entity && !$this->target->isPlayer()) || (Utils::distance_noroot($this->target, $ai->entity) > 256) || $this->target->level->getName() != $ai->entity->level->getName()){
			$this->reset();
			return;
		}
		
		$ai->mobController->moveTo($this->target->x, floor($ai->entity->y), $this->target->z);
		$ai->mobController->lookOn($this->target);
		$mult = $ai->entity instanceof Spider ? 1 : 2;
		$radius = ($ai->entity->width * $mult)*($ai->entity->width * $mult); 
		if(Utils::distance_noroot($this->target, $ai->entity) <= $radius && $this->attackTime <= 0){
			$ai->entity->attackEntity($this->target);
			$this->attackTime = 20;
		}
		--$this->attackTime;
		
	}
	public function canBeExecuted(EntityAI $ai)
	{
		$target = $this->findTarget($ai->entity, 16);
		if(($ai->entity instanceof Spider && !$ai->entity->level->isDay()) || $target instanceof Entity && $target->class === ENTITY_PLAYER && $target->isPlayer()){
			$this->target = $target; //TODO get rid of it
			$ai->entity->target = $target;
			return true;
		}
		
		return false;
	}
}

