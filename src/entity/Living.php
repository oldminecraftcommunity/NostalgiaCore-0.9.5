<?php

abstract class Living extends Entity implements Damageable{
    public $pathFinder, $pathFound, $path, $pathNavigator, $target, $ai;
    public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
        $this->pathFinder = new AStar($this);
        $this->pathFound = false;
        $this->target = false;
        $this->path = null;
        $this->ai = new EntityAI($this);
        $this->pathNavigator = new PathNavigator($this);
        parent::__construct($level, $eid, $class, $type, $data);
        $this->canBeAttacked = true;
	$this->hasGravity = true;
	$this->hasKnockback = true;
    }
    
    public function update(){
        
        $this->ai->updateTasks();
        parent::update();
    }
    
}
