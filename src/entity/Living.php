<?php
abstract class Living extends Entity implements Damageable, Pathfindable{
    
    public function __construct($level, $eid, $class){
        parent::__construct($level, $eid, $class);
        $this->canBeAttacked = true;
    }
    
	public function getPathfinder(){ //Placeholder
		return $this->pathFinder;
	}
}