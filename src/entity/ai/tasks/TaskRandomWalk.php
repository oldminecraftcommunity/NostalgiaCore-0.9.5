<?php

class TaskRandomWalk extends TaskBase
{
    private $x, $z, $setupLook = false;
    public function onStart(EntityAI $ai)
    {
        $this->x = mt_rand(-7, 7);
        $this->z = mt_rand(-7, 7);
        if($this->x = 0 && $this->z = 0){
            $this->reset();
            console("rip task");
            return false;
        }
        $this->selfCounter = floor(5 * Utils::distance($ai->entity, $ai->entity->add($this->x, 0, $this->z)));
        $this->setupLook = false;
    }

    public function onEnd(EntityAI $ai)
    {
        $this->x = $this->z = 0;
        $ai->entity->idleTime = mt_rand(20, 120);
    }

    public function onUpdate(EntityAI $ai)
    {
        if($ai->entity instanceof Creeper && $ai->entity->isIgnited()) {
            return false; //TODO Better way: block movement 
        }
        --$this->selfCounter;
        $ai->mobController->moveNonInstant($this->x, 0, $this->z);
        if(!$this->setupLook){
            $ai->mobController->lookAt($ai->entity->speedX, 0, $ai->entity->speedZ);
            $ai->entity->headYaw = $ai->entity->yaw;
            $ai->entity->idleTime = 10;
            $this->setupLook = true;
            return;
        }
        
    }

    public function canBeExecuted(EntityAI $ai)
    {
        if($ai->entity instanceof Creeper && $ai->entity->isIgnited()) {
            return false;
        }
        return !$ai->getTask("TaskLookAround")->isStarted;
    }

    
}