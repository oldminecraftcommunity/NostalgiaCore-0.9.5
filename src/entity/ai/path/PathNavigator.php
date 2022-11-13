<?php
class PathNavigator
{
    const PATH_COMPLETED = 0x1;
    const PATH_CONTINUE = 0x2;
    const PATH_CANT_CONTINUE = 0x3;
    public $entity;
    /**
     * @var Node
     */
    private $getTo;
    public $currentPointIndex;
    public function __construct(Creature &$entity){
        $this->entity = $entity;
        $this->currentPointIndex = 0;
    }
    
    
    public function reset(){
        $this->currentPointIndex = 0;
    }
    /**
     * @param Node[] $path
     */
    public function followPath($path){ //TODO remove local var
        if(!$this->canContinue()){
            console($this->getTo);
            console($this->entity);
            $diffX = $this->getTo->x - $this->entity->x;
            $diffY = 0; //todo ?
            $diffZ = $this->getTo->z - $this->entity->z;
            
            $this->entity->moveEntityWithOffset(Utils::getSign($diffX), Utils::getSign($diffY), Utils::getSign($diffZ));
            return self::PATH_CANT_CONTINUE;
        }
        $index = $this->currentPointIndex++;
        if($index >= count($path)){
            $this->onPathEnd();
            console("COMPLETED");
            return self::PATH_COMPLETED;
        }
        $node = $path[$index];
        
        $this->getTo = $node;
        
        $diffX = $node->x - $this->entity->x;
        $diffY = 0; //todo ?
        $diffZ = $node->z - $this->entity->z;
        
        $this->entity->moveEntityWithOffset(Utils::getSign($diffX), Utils::getSign($diffY), Utils::getSign($diffZ));
        
        return self::PATH_CONTINUE;
    }
    
    public function canContinue(){
        return empty($this->getTo) || (floor($this->entity->x) == floor($this->getTo->x) && floor($this->entity->z) == floor($this->getTo->z));
    }
    
    public function onPathEnd(){
        $this->currentPointIndex = 0;
        unset($this->getTo);
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

