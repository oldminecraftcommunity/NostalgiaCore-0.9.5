<?php

class TaskLookAround extends TaskBase
{
    private $rotation = 0;
    public function shouldBeExecuted(EntityAI $ai)
    {
        return !$ai->entity->isMoving() && $ai->entity->lookTime <= 0 && Utils::randomFloat() < 0.02  && $ai->entity->idleTime <= 0;
    }
    
    public function wasExecuted(EntityAI $ai){
        
        return $ai->entity->lookTime > 0 && $ai->entity->moveTime <= 0;
    }
    
    public function onStart(EntityAI $ai){
        $ai->entity->lookTime = 20 + mt_rand(0, 20);
        $this->rotation = mt_rand(-180,180);
    }
    
    public function onUpdate(EntityAI $ai)
    {
        //90 - 75 = -45deg rot
        //60 - 30 = 90deg rot
        //30 - 15 = -45deg rot
        if($ai->entity->lookTime === 1){
            $ai->entity->idleTime = mt_rand(10, 40);
        }
        $v = Utils::getSign($this->rotation) * 10;
        $ai->entity->yaw += $v;
        $pk = new RotateHeadPacket();
        $pk->eid = $ai->entity->eid;
        $pk->yaw = $ai->entity->yaw;
        $ai->entity->server->api->player->broadcastPacket($ai->entity->level->players, $pk);
        
        $this->rotation -= $v;
    }
}
