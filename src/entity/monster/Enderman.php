<?php

class Enderman extends Monster
{
	const TYPE = MOB_ENDERMAN;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 2.9);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setName("Enderman");
		$this->setSpeed(0.3);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 40, "generic");
	}
	
	
}

