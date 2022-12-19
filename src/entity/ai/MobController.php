<?php

class MobController
{
    /**
     * @var Entity
     */
    public $entity;
    
    public function __construct($e){
        $this->entity = $e;
    }
    
    public function moveNonInstant($x, $y, $z){
        if($x === $this->entity->x && $y === $this->entity->y && $z === $this->entity->z){
            return false; //failed
        }
        $this->entity->moveEntityWithOffset(($x > 0 ? 1 : ($x < 0 ? -1 : 0)), ($y > 0 ? 1 : ($y < 0 ? -1 : 0)), ($z > 0 ? 1 : ($z < 0 ? -1 : 0)));
        return true;
    }
    
    public function lookAt($x, $y = 0, $z = 0){
        if($x instanceof Entity){
            return $this->lookAt($x->x, $x->y, $x->z);
        }
        $this->entity->yaw = -atan2($x, $z) * 180 / M_PI;
        $this->entity->pitch = $y == 0 ? 0 : rad2deg(-atan2($y, sqrt(pow($x, 2) + pow($z, 2))));
        $this->entity->server->query("UPDATE entities SET pitch = ".$this->entity->pitch.", yaw = ".$this->entity->yaw." WHERE EID = ".$this->entity->eid.";");
        return true;
    }
    
    
    public function __destruct(){
        unset($this->entity);
    }
}

