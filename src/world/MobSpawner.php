<?php

class MobSpawner{
	private $server;
	public $level;
	const MOB_LIMIT = 25; //constant for now
	public function __construct(Level $level){
		$this->server = ServerAPI::request();
		$this->level = $level;
	}

	public function countEntities(){
		$ents = 0;
		foreach($this->level->entityList as $e){
			if(!$e->isPlayer() && $e->class === ENTITY_MOB){
				++$ents;
			}
		}
		return $ents;
	}

	public function handle(){
		if($this->countEntities() > self::MOB_LIMIT && count($this->level->players) <= 0){
			return false; //not spawning
		}
		return $this->spawnMobs();
	}

	public function spawnMobs(){
		
		$t = $this->level->getTime();
		if($this->server->api->getProperty("spawn-animals") && $t <= 9500){ //Animal
			$type = mt_rand(10, 13);
			$baby = false; //TODO baby
		}else
		if($this->server->api->getProperty("spawn-mobs") && $t >= 10000){ //Monster
			$type = mt_rand(32, 35);
			$baby = 2;
		}else{
			return false;
		}
		$x = mt_rand(0,255);
		$z = mt_rand(0,255);
		$y = $this->getSafeY($x, $z);
		if(!$y || $y < 0){
			return false;
		}
		$data = $this->genPosData($x, $y, $z);
		if($baby != 2) $data["IsBaby"] = $baby;
		$e = $this->server->api->entity->add($this->level, 2, $type, $data);
		if($e instanceof Entity){
			$this->server->api->entity->spawnToAll($e);
			//console("[DEBUG] $type spawned at $x, $y, $z");
		}
		return true;
	}
	
	private function genPosData($x, $y, $z){
		return [
			"x" => $x,
			"y" => $y,
			"z" => $z
		];
	}
	
	protected function getSafeY($x, $z){ //first safe block
		for($y = 0; $y < 128; ++$y){
			if($this->level->level->getBlock($x, $y, $z)[0] === AIR){
				return $y; //TODO checking aabb
			}
		}
		return false;
	}
}

