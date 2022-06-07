<?php

class Cow extends Animal{
	const TYPE = MOB_COW;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		console("A constructor which indicates it works! ".":".$eid.":".$class.":".$type);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->update();
		//$this->setName('Cow');
		$this->size = $this->isBaby() ? 0.65 : 1.4;
	}
}