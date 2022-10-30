<?php
class Pig extends Animal implements Rideable{
	const TYPE = MOB_PIG;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->server = ServerAPI::request();
		$this->setSize($this->isBaby() ? 0.45 : 0.9, $this->isBaby() ? 0.45 : 0.9);
		$this->setName("Pig");
		$this->update();
	}
	
	public function getMetadata(){
		$d = parent::getMetadata();
		if(!isset($this->data["Saddled"])){
			$this->data["Saddled"] = 0;
		}
		$d[16]["value"] = ((int)$this->data["Saddled"]);
		return $d;
	}
	
	public function isFood($id){
		return $id === POTATO || $id === CARROT || $id === BEETROOT;
	}
	
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : ($this->data["Saddled"] ? [
			[($this->fire > 0 ? COOKED_PORKCHOP : RAW_PORKCHOP), 0, mt_rand(0,2)],
			[SADDLE, 0, 1]
		] : [
			[($this->fire > 0 ? COOKED_PORKCHOP : RAW_PORKCHOP), 0, mt_rand(0,2)]
		]);
	}
}
