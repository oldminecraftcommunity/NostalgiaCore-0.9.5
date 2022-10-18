<?php

class Cow extends Animal{
	const TYPE = MOB_COW;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 10, "generic");
		$this->setSize($this->isBaby() ? 0.45 : 0.9 , $this->isBaby() ? 0.7 : 1.4);
		$this->setName('Cow');
		$this->update();
	}
	public function isFood($id){
		return $id === WHEAT;
	}
	
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : 
		array(	
			array(LEATHER, 0, mt_rand(0,2)),
			array(($this->fire > 0 ? STEAK:BEEF), 0, 1),
		);
	}

}