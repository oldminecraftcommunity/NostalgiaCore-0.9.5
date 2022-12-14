<?php
class MobSpawner{
	public function init(){
		$this->server = ServerAPI::request();
		$this->server->api->schedule(40, [$this, "checkForSpawn"], [], true);
	}
	
	public function checkForSpawn(){
		if(count($this->server->api->player->online()) <= 0) return;
		if($this->countMobs() >= 25) return;
		$this->spawnMobs();
	}
	
	public function countMobs(){
		$l = $this->server->query("SELECT EID FROM entities WHERE class = ".ENTITY_MOB.";");
		$cnt = 0;
		if($l !== false and $l !== true){
			while(($e = $l->fetchArray(SQLITE3_ASSOC)) !== false){
				$cnt++;
			}
		}
		return $cnt;
	}
	
	public function spawnMobs(){
		$o = $this->server->api->player->online();
		$randPlayer = mt_rand(0, (count($o) - 1));
		$this->world = $this->server->api->player->get($o[$randPlayer])->level;
		$this->gameTime = $this->world->getTime();
		
		if($this->gameTime <= 9500 and $this->server->api->getProperty("spawn-animals")){
			$this->spawnAnimal();
		}
		elseif($this->gameTime >= 10000 and $this->server->api->getProperty("spawn-mobs")){
			$this->spawnMonster();
		}
	}
	
	public function spawnAnimal(){
        $type = mt_rand(10, 13);
        $x = mt_rand(5, 250); //need create a radius near player
        $z = mt_rand(5, 250);
		$y = $this->getY($x, $z);
		if(!$y) return;
		
		$this->addMob(new Position($x+.5, $y, $z+.5, $this->world), ENTITY_MOB, $type);
	}
	
	public function spawnMonster(){
		$type = mt_rand(32, 35);
        $x = mt_rand(5, 250); //need create a radius near player
        $z = mt_rand(5, 250);
		$y = $this->getY($x, $z);
		if(!$y) return;
		
		$this->addMob(new Position($x+.5, $y, $z+.5, $this->world), ENTITY_MOB, $type);
	}
	
	public function getY($x, $z){
		if($this->gameTime <= 9500){
			for($y = 127; $y > 0; --$y){ //get highest block
				$block = $this->world->getBlock(new Vector3($x, $y, $z))->getID();
				if($block === GRASS){
					return ++$y;
				}
				if($block !== AIR){
					if($block == 18 or $block == 78 or $block == 31){ //Ignore Leaves, Snow Layer, Tall Grass
						continue;
					}
					return false;
				}
			}
			return false;
		}
		else{ //need recode that
			for($y = 1; $y < 127; ++$y){ //get lowest block
				$block = $this->world->getBlock(new Vector3($x, $y, $z));
				if($block->getID() === AIR){
					$downBlock = $this->world->getBlock(new Vector3($x, $y-1, $z));
					if($y === 1){
						return false;
					}
					if($downBlock instanceof LiquidBlock or $downBlock instanceof TransparentBlock){
						return false;
					}
					if(!($this->world->getBlock(new Vector3($x, $y+1, $z)) instanceof TransparentBlock)){
						return false;
					}
					return $y;
				}
			}
		}
	}
	
	public function addMob(Position $pos, $class, $type){
		$this->server->api->entity->summon($pos, $class, $type);
	}
	
	/*public function checkForDespawn(){
		$players = $this->server->api->player->getAll();
		$randEid = null;
		$entity = $this->server->api->entity->get($randEid);
		
		if(!$this->removeWhenFarAway($entity)) return;
		
		foreach($players as $p){
			if(Utils::distance($p, $entity) >= 48){
				$this->server->api->entity->remove($eid);
			}
		}
	}
	
	public function removeWhenFarAway($entity){ 
		if($entity instanceof Monster) return true;
		else return false;
	}*/
	
}