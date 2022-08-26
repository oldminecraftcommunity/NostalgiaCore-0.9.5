<?php
class Pig extends Animal{
	const TYPE = MOB_PIG;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->update();
		//$this->setName('Pig');
		$this->size = $this->isBaby() ? 0.60 : 1.1875;
	}
	public function isFood($id){
		return $id === POTATO || $id === CARROT || $id === BEETROOT;
	}
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : 
		array(
			array(($this->fire > 0 ? COOKED_PORKCHOP:RAW_PORKCHOP), 0, mt_rand(0,2)),
		);
	}

}
