<?php
class Zombie extends Monster{
	const TYPE = MOB_ZOMBIE;
	
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 20, "generic");
		$this->update();
		$this->setName('Zombie');
		$this->size = 1.95;
	}
	
	public function getDrops(){
		return array(
			array(CARROT, 0, Utils::chance(0.83) ? 1 : 0),
			array(POTATO, 0, Utils::chance(0.83) ? 1 : 0),
			array(FEATHER, 0, mt_rand(0,2)),
		);
	}
}