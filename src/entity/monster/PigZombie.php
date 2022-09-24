<?php
class PigZombie extends Monster{
	const TYPE = MOB_PIGMAN;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 20, "generic");
		$this->update();
		$this->setName('Pigman');
		$this->size = 1.8; //not original
	}
	
	public function getDrops(){
		return array(
			array(COOKED_PORKCHOP, 0, mt_rand(0,2)),
			array(GOLD_INGOT, 0, mt_rand(0,1)),
		);
	}
}