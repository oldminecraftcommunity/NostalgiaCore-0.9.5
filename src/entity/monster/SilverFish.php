<?php

class SilverFish extends Monster
{
	const TYPE = MOB_SILVERFISH;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.3, 0.7);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setSpeed(0.3);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 8, "generic");
		$this->setName("Silverfish");
	}
}

