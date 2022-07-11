<?php
/*
TODO:
move methods
*/
abstract class Creature extends Living{
	const CLASS_TYPE = ENTITY_MOB;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:1, "generic");
		$this->update();
		//$this->setName((isset($mobs[$this->type]) ? $mobs[$this->type]:$this->type));
		$this->size = 1;
	}
}