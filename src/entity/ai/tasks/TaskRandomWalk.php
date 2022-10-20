<?php

class TaskRandomWalk extends TaskBase
{
    private $x, $z, $delay = 10, $newPos, $looking = false;
    public function shouldBeExecuted(EntityAI $ai)
    {
        return !$ai->entity->pathFound && $ai->entity->moveTime <= 0 && $ai->entity->lookTime <= 0 && $ai->entity->idleTime <= 0 && !($ai->entity->target instanceof Entity) && mt_rand(0,3) == 1;
    }
    
    public function wasExecuted(EntityAI $ai)
    {
        return $ai->entity->moveTime > 0;
    }
    public function onStart(EntityAI $ai)
    {
        $this->x = mt_rand(-7, 7);
        $this->z = mt_rand(-7, 7);
        $this->newPos = $ai->entity->add($this->x, 0, $this->z);
        $ai->entity->moveTime = 15 * Utils::distance($ai->entity, $this->newPos);
    }

    public function onUpdate(EntityAI $ai)
    {
        if($this->delay > 0 && !$this->looking){
            --$this->delay;
            try{
                return;
            }finally{
                $this->testLook($ai, ($this->x > 0 ? 0.1 : ($this->x < 0 ? -0.1 : 0)), ($this->z > 0 ? 0.1 : ($this->z < 0 ? -0.1 : 0)));
                $pk = new RotateHeadPacket();
                $pk->eid = $ai->entity->eid;
                $pk->yaw = $ai->entity->yaw;
                $ai->entity->server->api->player->broadcastPacket($ai->entity->level->players, $pk);
                $this->looking = true;
            }
        }
        if($ai->entity->moveTime <= 1){
            $ai->entity->idleTime = mt_rand(10,100);
            $this->looking = false;
        }
        if(!$ai->entity->isMoving()){
            $ai->entity->addVelocity(($this->x > 0 ? 0.1 : ($this->x < 0 ? -0.1 : 0)), 0, ($this->z > 0 ? 0.1 : ($this->z < 0 ? -0.1 : 0)));
        }
    }
    public function updateLook($ai){
        $ai->entity->server->query("UPDATE entities SET pitch = ".$ai->entity->pitch.", yaw = ".$ai->entity->yaw." WHERE EID = ".$ai->entity->eid.";");
    }
    public function testLook($ai, $vX, $vZ){
        $x = $this->newPos->x - $ai->entity->x;
        $y = $this->newPos->y - $ai->entity->y;
        $z = $this->newPos->z - $ai->entity->z;
        $ai->entity->yaw = -atan2($vX, $vZ) * 180 / M_PI;
        $ai->entity->pitch = $y == 0 ? 0 : rad2deg(-atan2($y, sqrt(pow($x, 2) + pow($z, 2))));
        $ai->entity->server->query("UPDATE entities SET pitch = ".$ai->entity->pitch.", yaw = ".$ai->entity->yaw." WHERE EID = ".$ai->entity->eid.";");
    }
}

