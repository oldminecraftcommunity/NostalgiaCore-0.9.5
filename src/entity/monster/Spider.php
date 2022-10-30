<?php
class Spider extends Monster{
	const TYPE = MOB_SPIDER;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 8, "generic");
		$this->setName("Spider");
		$this->setSize(1.4, 0.9);
		$this->update();
	}
	
	public function getDrops(){
		return [
			[STRING, 0, mt_rand(0,2)]
		];
	}
}