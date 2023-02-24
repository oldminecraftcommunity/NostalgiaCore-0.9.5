<?php

class Slime extends Monster{
	const TYPE = MOB_SLIME;
	public $size;
	
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setName("Slime");
		/* Health formula
		 * SlimeSize = Slime::getSlimeSize(this);
  		 * return SlimeSize * SlimeSize;
		 */
		$this->setSlimeSize(nullsafe($data["Size"], (1 << mt_rand(0, 2))));
	}
	
	public function getSlimeSize(){
		return $this->size;
	}
	
	public function makeDead($cause){
		$cnt = 2 + mt_rand(0, 2);
		$s = $this->size;
		if($s > 1){
			for($i = 0; $i < $cnt; ++$i){
				$xOff = (($cnt % 2) - 0.5) * $s / 4;
				$zOff = (($cnt / 2) - 0.5) * $s / 4;
				$e = $this->server->api->entity->add($this->level, $this->class, $this->type, [
					"x" => $this->x + $xOff,
					"y"=> $this->y + 1,
					"z" => $this->z + $zOff,
					"Size" => (int) ($s / 2)
				]);
				$this->server->api->entity->spawnToAll($e);
			}
		}
		parent::makeDead($cause);
	}
	
	public function setSlimeSize($i){
		$this->size = $i;
		$this->setSize(0.6 * $i, 0.6 * $i);
		$this->setHealth($i * $i);
	}
	
	public function createSaveData(){
		$sd = parent::createSaveData();
		$sd["Size"] = $this->size;
		return $sd;
	}
	
	public function getMetadata(){
		$ret = parent::getMetadata();
		$ret[16]["value"] = $this->size;
		return $ret;
	}
}

