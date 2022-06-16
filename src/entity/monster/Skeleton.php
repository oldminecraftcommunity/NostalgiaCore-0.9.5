<?php
class Skeleton extends Monster{
	const TYPE = MOB_SKELETON;
	
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 20, "generic");
		$this->update();
		//$this->setName('Skeleton');
		$this->size = 1.9;
	}
	
	public function getDrops(){
		return array(
			array(ARROW, 0, mt_rand(0,2)),
			array(BONE, 0, mt_rand(0,2)),
		);
	}
}