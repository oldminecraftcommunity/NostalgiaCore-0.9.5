<?php
class Zombie extends Monster{
	const TYPE = MOB_ZOMBIE;
	function __construct(Level $level, $eid, $class, $type = 0, $data = array()){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 12, "generic");
		$this->setName("Zombie");
		$this->setSize(0.6, 1.85);
		$this->setSpeed(0.23);
		$this->update();
		//$this->server->schedule(20, [$this, "burnable"], null, true); //todo
	}
	
	public function burnable(){
		if($this->fire > 0 or $this->server->api->time->getPhase($this->level->getTime()) == "day"){
			return;
		}
		$y = $this->y;
		for(; $y < 129; $y++){
			$block = $this->level->getBlock(new Vector3($this->x, $y, $this->z));
			if($block->isSolid){ //?
				return false;
			}
		}
		$block = $this->level->getBlock(new Vector3($this->x, $y, $this->z))->getID();
		if($block === AIR){
			$this->fire = 200;
			$this->updateMetadata();
			return true;
		}else{
			return false;
		}
	}
	
	public function getDrops(){
		return [
			[CARROT, 0, Utils::chance(0.83) ? 1 : 0],
			[POTATO, 0, Utils::chance(0.83) ? 1 : 0],
			[FEATHER, 0, mt_rand(0,2)]
		];
	}
}