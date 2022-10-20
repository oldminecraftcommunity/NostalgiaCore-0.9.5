<?php

class TaskLookAround extends TaskBase
{
    private $finYaw = 0;
    public function shouldBeExecuted(EntityAI $ai)
    {
        return !$ai->entity->isMoving() && $ai->entity->lookTime <= 0 && mt_rand(0,30) == 1  && $ai->entity->idleTime <= 0 && !($ai->lastTask instanceof TaskLookAround);
    }
    
    public function wasExecuted(EntityAI $ai){
        
        return $ai->entity->lookTime > 0;
    }
    
    public function onStart(EntityAI $ai){
        $ai->entity->lookTime = 120;
        $this->finYaw = $ai->entity->yaw;
    }
    
    public function onUpdate(EntityAI $ai)
    {
        //90 - 75 = -45deg rot
        //60 - 30 = 90deg rot
        //30 - 15 = -45deg rot
        if($ai->entity->lookTime === 1){
            $ai->entity->idleTime = mt_rand(40, 200);
        }
        if(Utils::in_range($ai->entity->lookTime, 105, 120) || Utils::in_range($ai->entity->lookTime, 15, 30)){
            $ai->entity->yaw -= 3;
        }
        if(Utils::in_range($ai->entity->lookTime, 50, 80)){
            $ai->entity->yaw += 3;
        }
        
        $pk = new RotateHeadPacket();
        $pk->eid = $ai->entity->eid;
        $pk->yaw = $ai->entity->yaw;
        $ai->entity->server->api->player->broadcastPacket($ai->entity->level->players, $pk);
    }
    public function testLook($pos){
        
        
        
    }
}

