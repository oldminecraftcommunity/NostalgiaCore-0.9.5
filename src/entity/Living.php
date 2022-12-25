<?php

abstract class Living extends Entity implements Damageable{
    public $target, $ai;
    public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
        $this->target = false;
        $this->ai = new EntityAI($this);
        parent::__construct($level, $eid, $class, $type, $data);
        $this->canBeAttacked = true;
	$this->hasGravity = true;
	$this->hasKnockback = true;
    }
    
    public function update(){
        if($this->idleTime <= 0) {
            $this->ai->updateTasks();
        }
        parent::update();
    }
    
}
