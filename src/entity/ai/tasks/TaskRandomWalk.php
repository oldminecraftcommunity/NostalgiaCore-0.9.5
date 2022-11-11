<?php

class TaskRandomWalk extends TaskBase
{
    private $x, $z, $delay = 10, $newPos, $looking = false;
    public function shouldBeExecuted(EntityAI $ai)
    {
        if($ai->entity instanceof Creeper && $ai->entity->isIgnited()){
        	return false;
        }
        return !$ai->entity->pathFound && $ai->entity->moveTime <= 0 && $ai->entity->lookTime <= 0 && $ai->entity->idleTime <= 0 && !($ai->entity->target instanceof Entity) && mt_rand(0,3) == 1;
    }
    
    public function wasExecuted(EntityAI $ai)
    {
        return $ai->entity->moveTime > 0 && ($this->x != 0 || $this->z != 0);
    }
    public function onStart(EntityAI $ai)
    {
        $this->x = mt_rand(-7, 7);
        $this->z = mt_rand(-7, 7);
        $this->newPos = $ai->entity->add($this->x, 0, $this->z);
        $ai->entity->moveTime = floor(5 * Utils::distance($ai->entity, $this->newPos));
        $this->looking = true;
    }

    public function onUpdate(EntityAI $ai)
    {
        if($ai->entity->moveTime <= 1){
            $ai->entity->idleTime = mt_rand(10,40);
            $this->x = 0;
            $this->z = 0;
            $this->looking = false;
        }
        $ai->entity->moveEntityWithOffset(($this->x > 0 ? 1 : ($this->x < 0 ? -1 : 0)), 0, ($this->z > 0 ? 1 : ($this->z < 0 ? -1 : 0)));
        if($this->looking){
            $this->testLook($ai, $ai->entity->speedX, $ai->entity->speedZ);
            $pk = new RotateHeadPacket();
            $pk->eid = $ai->entity->eid;
            $pk->yaw = $ai->entity->yaw;
            $ai->entity->server->api->player->broadcastPacket($ai->entity->level->players, $pk);
            $this->looking = false;
        }
    }
    public function updateLook($ai){
        $ai->entity->server->query("UPDATE entities SET pitch = ".$ai->entity->pitch.", yaw = ".$ai->entity->yaw." WHERE EID = ".$ai->entity->eid.";");
    }
    public function testLook($ai, $vX, $vZ){
        $ai->entity->yaw = -atan2($vX, $vZ) * 180 / M_PI;
        //nopitch $ai->entity->pitch = $y == 0 ? 0 : rad2deg(-atan2($y, sqrt(pow($x, 2) + pow($z, 2))));
        $ai->entity->server->query("UPDATE entities SET pitch = ".$ai->entity->pitch.", yaw = ".$ai->entity->yaw." WHERE EID = ".$ai->entity->eid.";");
    }
}