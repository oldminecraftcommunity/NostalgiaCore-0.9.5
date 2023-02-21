<?php

class Villager extends Neutral //TODO AI
{
	const TYPE = MOB_VILLAGER;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 1.8);
		$this->setSpeed(0.3);
		$this->setName("Villager");
		parent::__construct($level, $eid, $class, $type, $data);
	}
}

