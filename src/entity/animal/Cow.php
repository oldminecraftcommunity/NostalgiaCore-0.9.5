<?php

class Cow extends Animal{
	const TYPE = MOB_COW;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->update();
		//$this->setName('Cow');
		$this->size = $this->isBaby() ? 0.65 : 1.4;
	}
	
	
	public function getDrops(){
		return $this->isBaby() ? array() : 
		array(	
			array(LEATHER, 0, mt_rand(0,2)),
			array(($this->fire > 0 ? STEAK:BEEF), 0, 1),
		);
	}

}