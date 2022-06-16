<?php
class Spider extends Monster{
	const TYPE = MOB_SPIDER;
	
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:20, "generic");
		$this->update();
		//$this->setName('Spider');
		$this->size = 0.6; //not original
	}
	
	public function getDrops(){
		return array(
			array(STRING, 0, mt_rand(0,2)),
		);
	}
}