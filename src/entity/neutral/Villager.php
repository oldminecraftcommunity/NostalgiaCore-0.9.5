<?php

class Villager extends Neutral //TODO AI
{
	const TYPE = MOB_VILLAGER;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 1.8);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setSpeed(0.3);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 10, "generic");
		$this->setName("Villager");
	}
}

