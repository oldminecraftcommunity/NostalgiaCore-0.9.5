<?php
class Creeper extends Monster{
	const TYPE = MOB_CREEPER;
	
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:16, "generic");
		$this->setName('Creeper');
		$this->setSize(0.6, 1.7);
		$this->update();
		
	}
	
	public function getDrops(){
		return array(
			array(GUNPOWDER, 0, mt_rand(0,2)),
		);
	}
}