<?php

class Sheep extends Animal{
	const TYPE = MOB_SHEEP;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		console("A constructor which indicates it works! ".":".$eid.":".$class.":".$type);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:8, "generic");
		$this->update();
		//$this->setName('Sheep');
		$this->size = $this->isBaby() ? 0.65 : 1.3;
	}
}