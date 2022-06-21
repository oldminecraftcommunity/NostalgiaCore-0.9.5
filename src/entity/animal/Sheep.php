<?php

class Sheep extends Animal{
	const TYPE = MOB_SHEEP;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 8, "generic");
		$this->update();
		//$this->setName('Sheep');
		$this->size = $this->isBaby() ? 0.65 : 1.3;
	}
	
	public function getDrops(){
		return $this->isBaby() ? array() : 
		array(
			array(WOOL, $this->data["Color"] & 0x0F, 1),
		);
	}
	
	public function isFood($id){
		return $id === WHEAT;
	}
	
	public function getMetadata(){
		$d = parent::getMetadata();
		if(!isset($this->data["Sheared"])){
			$this->data["Sheared"] = 0;
			$this->data["Color"] = $this->sheepColor();
		}
		$d[16]["value"] = (($this->data["Sheared"] == 1 ? 1:0) << 4) | ($this->data["Color"] & 0x0F); //dark manipulations are happening here...
		return $d;
	}
	public function sheepColor(){
		$pink = 0.1558;
		$brown = 2.85;
		$lightgray_black_gray = 14.25;
		$chance = Utils::randomFloat() * 100;
		switch($chance){
			case($chance <= $pink):
				$color = 6;
				break;
			case($chance > $pink and $chance <= ($brown+$pink)):
				$color = 12;
				break;
			case($chance > ($brown+$pink) and $chance <= ($lightgray_black_gray+$brown+$pink)):
				$rand = mt_rand(1,3);
				if($rand == 1) $color = 15;
				elseif($rand == 2) $color = 7;
				else $color = 8;
				break;
			default:
				$color = 0;
				break;
		}
		return $color;
	}
}