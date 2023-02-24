<?php

class Wolf extends Animal implements Tameable
{
	const TYPE = MOB_WOLF;
	
	const WOLF_FLAGS = 14;
	
	const WF_SITTING = 1;
	const WF_ANGRY = 2;
	const WF_INTERESTED = 3;
	
	protected $interested = false;
	protected $angry = false;
	protected $sitting = false;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize(0.6, 0.8);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setSpeed(0.3);
		$this->setName("Wolf");
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 10, "generic");
	}
	
	public function getMetadata(){
		$ret = parent::getMetadata();
		$ret[self::WOLF_FLAGS] = ["type" => 0, "value" => 
			(($this->angry) << self::WF_ANGRY) ^ 
			(($this->interested) << self::WF_INTERESTED) ^
			(($this->sitting) << self::WF_SITTING)
		];//TODO toggles
		return $ret;
	}
	
	public function isTamed()
	{
		return false;
	}

	public function getOwner()
	{
		return null;
	}
	public function isFood($id) //TODO
	{
		return false;
	}


}

