<?php
class PigZombie extends Monster{
	const TYPE = MOB_PIGMAN;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 12, "generic");
		$this->setSize(0.3, 1.95);
		$this->setName("Pigman");
		$this->update();
	}
	
	public function getDrops(){
		return [
			[COOKED_PORKCHOP, 0, mt_rand(0,2)],
			[GOLD_INGOT, 0, mt_rand(0,1)]
		];
	}
}