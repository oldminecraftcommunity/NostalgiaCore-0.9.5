<?php
class Pig extends Animal{
	const TYPE = MOB_PIG;
	public $server;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->server = ServerAPI::request();
		$this->setSize($this->isBaby() ? 0.45 : 0.9, $this->isBaby() ? 0.45 : 0.9);
		$this->setName('Pig');
		$this->update();
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
