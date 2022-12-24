<?php

class TaskLookAround extends TaskBase
{
    private $rotation;
    public function onStart(EntityAI $ai)
    {
        $this->selfCounter = 1;
        $this->rotation = mt_rand(-120, 120);
    }

    public function onEnd(EntityAI $ai)
    {
        $ai->entity->idleTime = mt_rand(20, 40);
    }

    public function canBeExecuted(EntityAI $ai)
    {
    	return !$ai->entity->isMoving() && Utils::randomFloat() < 0.02 && !$ai->isStarted("TaskLookAtPlayer") && !$ai->isStarted("TaskTempt"); /*Vanilla value*/
    }

    public function onUpdate(EntityAI $ai)
    {
        if($this->rotation === 0){
            $this->selfCounter = 0;
        }
        $v = min(Utils::getSign($this->rotation) * 10, $this->rotation);
        $ai->entity->yaw += $v;
        $pk = new RotateHeadPacket(); //TODO headYaw auto update
        $pk->eid = $ai->entity->eid;
        $pk->yaw = $ai->entity->yaw;
        $ai->entity->server->api->player->broadcastPacket($ai->entity->level->players, $pk);
        $this->rotation -= $v;
        
    }
}
