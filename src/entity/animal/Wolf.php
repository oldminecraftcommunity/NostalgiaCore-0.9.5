<?php

class Wolf extends Animal implements Tameable
{
	const TYPE = MOB_WOLF;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 0.8);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setSpeed(0.3);
		$this->setName("Wolf");
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 10, "generic");
	}
	
	
	public function isTamed()
	{
		return false;
	}

	public function getOwner()
	{
		return null;
	}
	public function isFood($id) //TODO
	{
		return false;
	}


}

