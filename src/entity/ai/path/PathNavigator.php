<?php
class PathNavigator
{
    public $entity;
    public $currentPointIndex;
    public function __construct(Creature &$entity){
        $this->entity = $entity;
        $this->currentPointIndex = 0;
    }
    
    public function reset(){
        $this->currentPointIndex = 0;
    }
    
    public function followPath($path){ //TODO remove local var
        if($this->currentPointIndex >= count($path)){
            $this->entity->moveTime = mt_rand(100, 200);
            try{
                return true; //path finished
            }finally {
                $this->reset();
            }
        }
        $point = $path[$this->currentPointIndex];
        $eX = ceil($this->entity->x);
        $eY = ceil($this->entity->y);
        $eZ = ceil($this->entity->z);
        //console($point.":::".$eX.":".$eY.":".$eZ."::::".$this->entity->moveTime);
        if($this->entity->moveTime <= 0 && $point->x === $eX && $point->y === $eY && $point->z === $eZ){
            ++$this->currentPointIndex;
        }elseif($this->entity->moveTime <= 0 && !$this->entity->isMoving()){
            //console($point.":::".$eX.":".$eY.":".$eZ);
            $vX = $point->x - $eX;
            $vY = 0;//$point->y - $this->entity->y; //vY is always 0 in current pathfinder\
            $vZ = $point->z - $eZ;
            //console($vX."::".$vZ);
            $this->entity->addVelocity(($vX > 0 ? 0.1 : ($vX < 0 ? -0.1 : 0)), $vY, ($vZ > 0 ? 0.1 : ($vZ < 0 ? -0.1 : 0)));
            $this->testLook($point);
            //console($this->entity->yaw);
            $this->entity->moveTime = 5; //use 20 for debug
        }
        //$this->entity->moveTime = 5*
        return false;
    }
    
    public function testLook($pos){
        $x = $pos->x - $this->entity->x;
        $y = $pos->y - $this->entity->y;
        $z = $pos->z - $this->entity->z;
        $this->entity->yaw = -atan2($this->entity->speedX, $this->entity->speedZ) * 180 / M_PI;
        $this->entity->pitch = $y == 0 ? 0 : rad2deg(-atan2($y, sqrt(pow($x, 2) + pow($z, 2))));
        $this->entity->server->query("UPDATE entities SET pitch = ".$this->entity->pitch.", yaw = ".$this->entity->yaw." WHERE EID = ".$this->entity->eid.";");
    }
}

