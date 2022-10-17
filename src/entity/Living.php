<?php
abstract class Living extends Entity implements Damageable, Pathfindable{
    
    public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
        parent::__construct($level, $eid, $class, $type, $data);
        $this->canBeAttacked = true;
    }
    
	public function getPathfinder(){ //Placeholder
		return $this->pathFinder;
	}
}