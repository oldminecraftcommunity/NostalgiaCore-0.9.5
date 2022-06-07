<?php
class Pig extends Animal{
	const TYPE = MOB_PIG;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		console("A constructor which indicates it works! ".":".$eid.":".$class.":".$type);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->update();
		//$this->setName('Pig');
		$this->size = $this->isBaby() ? 0.60 : 1.1875;
	}
}