<?php

class TaskLookAround extends TaskBase
{
    private $finYaw = 0;
    public function shouldBeExecuted(EntityAI $ai)
    {
        return !$ai->entity->isMoving() && $ai->entity->lookTime <= 0 && mt_rand(0,30) == 1  && $ai->entity->idleTime <= 0;
    }
    
    public function wasExecuted(EntityAI $ai){
        
        return $ai->entity->lookTime > 0 && $ai->entity->moveTime <= 0;
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
            $ai->entity->idleTime = mt_rand(10, 40);
        }
        if(Utils::in_range($ai->entity->lookTime, 45, 60) || Utils::in_range($ai->entity->lookTime, 0, 15)){
            $ai->entity->yaw -= 3;
        }
        if(Utils::in_range($ai->entity->lookTime, 15, 45)){
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
