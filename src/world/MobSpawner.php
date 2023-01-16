<?php

class MobSpawner{
	public static $spawnAnimals = false, $spawnMobs = false;
	private $server;
	public $level;
	const MOB_LIMIT = 50; //constant for now
	public function __construct(Level $level){
		$this->server = ServerAPI::request();
		$this->level = $level;
	}

	public function countEntities(){
		$ents = 0;
		foreach($this->level->entityList as $e){
			if(!$e->isPlayer() && $e->class === ENTITY_MOB) ++$ents;
		}
		return $ents;
	}

	public function handle(){
		if($this->countEntities() > self::MOB_LIMIT || count($this->level->players) <= 0){
			return false; //not spawning
		}
		return $this->spawnMobs();
	}

	public function spawnMobs(){
		
		if(self::$spawnAnimals && $this->level->isDay()){ //Animal
			$type = mt_rand(10, 13);
			$baby = false; //TODO baby
			$grassOnly = true;
		}elseif(self::$spawnMobs && $this->level->isNight()){ //Monster
			$type = mt_rand(32, 35);
			$grassOnly = false;
			$baby = 2;
		}else{
			return false;
		}
		$x = mt_rand(0,255);
		$z = mt_rand(0,255);
		$y = $this->getSafeY($x, $z, $grassOnly);
		if(!$y || $y < 0){
			return false;
		}
		$data = $this->genPosData($x, $y + 1, $z);
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
			"x" => $x + 0.5,
			"y" => $y,
			"z" => $z + 0.5
		];
	}
	
	protected function getSafeY($x, $z, $grassOnly = false){ //first safe block
		$allowed = [];
		for($y = 0; $y < 128; ++$y){
			$b = $this->level->getBlockWithoutVector($x, $y, $z);
			$b1 = $this->level->getBlockWithoutVector($x, $y - 1, $z);
			if(!$b->isSolid && ($b1->isSolid && ($grassOnly ? $b1->getID() === GRASS : true))){
				$allowed[] = $y;
			}
		}
		
		return empty($allowed) ? -1 : $allowed[mt_rand(0, count($allowed) - 1)];
	}
}

