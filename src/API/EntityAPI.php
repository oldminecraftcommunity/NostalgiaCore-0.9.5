<?php

/**
 *
 *  ____            _        _   __  __ _                  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_| 
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 * 
 *
*/

class EntityAPI{
	private $server;
	public $entities;
	private $eCnt = 1;

	function __construct(){
		$this->entities = array();
		$this->server = ServerAPI::request();
		
		$this->hp = array(
			10 => 4,
			11 => 10,
			12 => 10,
			13 => 8,

			32 => 20,
			33 => 20,
			34 => 20,
			35 => 16,
			36 => 20,
		);
		
		$this->mob = array(
			"chicken" => 10,
			"cow" => 11,
			"pig" => 12,
			"sheep" => 13,

			"zombie" => 32,
			"creeper" => 33,
			"skeleton" => 34,
			"spider" => 35,
			"pigman" => 36,
		);
		
		$this->mobName = array(
			10 => "Chicken",
			11 => "Cow",
			12 => "Pig",
			13 => "Sheep",

			32 => "Zombie",
			33 => "Creeper",
			34 => "Skeleton",
			35 => "Spider",
			36 => "Pigman",
		);
		
		$this->serverSpawnAnimals = $this->server->api->getProperty("spawn-animals");
		$this->serverSpawnMobs = $this->server->api->getProperty("spawn-mobs");
	}

	public function get($eid){
		if(isset($this->entities[$eid])){
			return $this->entities[$eid];
		}
		return false;
	}
	
	public function init(){
		$this->server->schedule(25, array($this, "updateEntities"), array(), true);
		$this->server->api->console->register("summon", "<mob>", array($this, "commandHandler"));
		$this->server->api->console->register("spawnmob", "<mob>", array($this, "commandHandler"));
		$this->server->api->console->register("despawn", "", array($this, "CommandHandler"));
	}
	
	public function commandHandler($cmd, $args, $issuer, $alias){
		$output = "";
        switch ($cmd){
			case 'summon':
			case 'spawnmob':
			
			if(!($issuer instanceof Player)){
				$output .= "Please run this command in-game.";
				break;
			}
			if((count($args) < 1) or (count($args) > 3)){
				$output .= "Usage: /$cmd <mob> [amount] [baby]";
				break;
			}
			
			$type = $this->mob[strtolower($args[0])];
			if($type != (10 or 11 or 12 or 13 or 32 or 33 or 34 or 35 or 36)){
				$output .= "Unknown mob.";
				break;
			}
			
			if(count($args) == 1){//summon <mob>
			
				$spawnX = round($issuer->entity->x, 1, PHP_ROUND_HALF_UP);
				$spawnY = round($issuer->entity->y, 1, PHP_ROUND_HALF_UP);
				$spawnZ = round($issuer->entity->z, 1, PHP_ROUND_HALF_UP);
				$spawnLevel = $issuer->entity->level;
				
				$entityit = $this->add($spawnLevel, ENTITY_MOB, $type, array(
					"x" => $spawnX,
					"y" => $spawnY,
					"z" => $spawnZ,
					"Health" => $this->hp[$type],
				));
				$this->spawnToAll($entityit, $level);
				$output .= $this->mobName[$type]." spawned in ".$spawnX.", ".$spawnY.", ".$spawnZ.".";
				break;
			}
			elseif(is_numeric($args[1])){//summon <mob> [amount]
				$amount = (int)$args[1];
				if($amount > 25){
					$output .= "Cannot spawn > 25 mobs";
					break;
				}
				
				$isBaby = 0;
				if(strtolower($args[2]) == 'baby'){//summon <mob> [amount] [baby]
					if($type > 13){
						$output .= "This mob cant be baby!";
						break;
					}
					$isBaby = 1;
				}
				
				$spawnX = round($issuer->entity->x, 1, PHP_ROUND_HALF_UP);
				$spawnY = round($issuer->entity->y, 1, PHP_ROUND_HALF_UP);
				$spawnZ = round($issuer->entity->z, 1, PHP_ROUND_HALF_UP);
				$spawnLevel = $issuer->entity->level;
				
				for($cnt = $amount; $cnt > 0; --$cnt){
					$entityit = $this->add($spawnLevel, ENTITY_MOB, $type, array(
						"x" => $spawnX,
						"y" => $spawnY,
						"z" => $spawnZ,
						"Health" => $this->hp[$type],
						"IsBaby" => $isBaby,
					));
					$this->spawnToAll($entityit, $level);
				}
				
				if($type == 13 or $amount == 1) $plural = '';
				else $plural = 's';
				
				if($isBaby == 1) $baby = "Baby ";
				else $baby = '';
				
				$output .= $amount." ".$baby.$this->mobName[$type].$plural." spawned in ".$spawnX.", ".$spawnY.", ".$spawnZ.".";
				
				break;
				}
				elseif(strtolower($args[1]) == 'baby'){//summon <mob> [baby]
					if($type > 13){
						$output .= "Baby can be only animals!";
						break;
					}
					else{
						$spawnX = round($issuer->entity->x, 1, PHP_ROUND_HALF_UP);
						$spawnY = round($issuer->entity->y, 1, PHP_ROUND_HALF_UP);
						$spawnZ = round($issuer->entity->z, 1, PHP_ROUND_HALF_UP);
						$spawnLevel = $issuer->entity->level;
						
						$entityit = $this->add($spawnLevel, ENTITY_MOB, $type, array(
							"x" => $spawnX,
							"y" => $spawnY,
							"z" => $spawnZ,
							"Health" => $this->hp[$type],
							"isBaby" => 1,
						));
						$this->spawnToAll($entityit, $level);
						$output .= "Baby ".$this->mobName[$type]." spawned in ".$spawnX.", ".$spawnY.", ".$spawnZ.".";
						break;
					}
					break;
				}
			case 'despawn':
				$cnt = 0;
				$l = $this->server->query("SELECT EID FROM entities WHERE class = ".ENTITY_MOB.";");
				if ($l !== false and $l !== true){
					while(($e = $l->fetchArray(SQLITE3_ASSOC)) !== false){
						$e = $this->get($e["EID"]);
						if ($e instanceof Entity){
							$this->remove($e->eid);
							$cnt++;
						}
					}
				}
				$output .= $cnt." mobs has been despawned!";
				break;
		}
	return $output;
	}
	
	public function updateEntities(){
		$l = $this->server->query("SELECT EID FROM entities WHERE hasUpdate = 1;");
		
		if($l !== false and $l !== true){
			while(($e = $l->fetchArray(SQLITE3_ASSOC)) !== false){
				$e = $this->get($e["EID"]);
				if($e instanceof Entity){
					$e->update();
					$this->server->query("UPDATE entities SET hasUpdate = 0 WHERE EID = ".$e->eid.";");
				}
			}
		}
	}
	
	public function updateRadius(Position $center, $radius = 15, $class = false){
		$this->server->query("UPDATE entities SET hasUpdate = 1 WHERE level = '".$center->level->getName()."' ".($class !== false ? "AND class = $class ":"")."AND abs(x - {$center->x}) <= $radius AND abs(y - {$center->y}) <= $radius AND abs(z - {$center->z}) <= $radius;");
	}

	public function getRadius(Position $center, $radius = 15, $class = false){
		$entities = array();
		$l = $this->server->query("SELECT EID FROM entities WHERE level = '".$center->level->getName()."' ".($class !== false ? "AND class = $class ":"")."AND abs(x - {$center->x}) <= $radius AND abs(y - {$center->y}) <= $radius AND abs(z - {$center->z}) <= $radius;");
		if($l !== false and $l !== true){
			while(($e = $l->fetchArray(SQLITE3_ASSOC)) !== false){
				$e = $this->get($e["EID"]);
				if($e instanceof Entity){
					$entities[$e->eid] = $e;
				}
			}
		}
		return $entities;
	}
	
	public function getAll($level = null){
		if($level instanceof Level){
			$entities = array();
			$l = $this->server->query("SELECT EID FROM entities WHERE level = '".$level->getName()."';");
			if($l !== false and $l !== true){
				while(($e = $l->fetchArray(SQLITE3_ASSOC)) !== false){
					$e = $this->get($e["EID"]);
					if($e instanceof Entity){
						$entities[$e->eid] = $e;
					}
				}
			}
			return $entities;
		}
		return $this->entities;
	}

	public function heal($eid, $heal = 1, $cause){
		$this->harm($eid, -$heal, $cause);
	}

	public function harm($eid, $attack = 1, $cause, $force = false){
		$e = $this->get($eid);
		if($e === false or $e->dead === true){
			return false;
		}
		$e->setHealth($e->getHealth() - $attack, $cause, $force);
	}

	public function add(Level $level, $class, $type = 0, $data = array()){
		$eid = $this->eCnt++;
		$efl = EntityRegistry::$entityList->getEntityFromType($type);
		if($efl instanceof PropertyEntity){
			$class = $efl->getEntityName();
			$this->entities[$eid] = new $class($level, $eid, $efl->getEntityClass(), $efl->getEntityType(), $data);
		}else{
			$this->entities[$eid] = new Entity($level, $eid, $class, $type, $data);
		}
		$this->server->handle("entity.add", $this->entities[$eid]);
		return $this->entities[$eid];
	}

	public function spawnToAll(Entity $e){
		foreach($this->server->api->player->getAll($e->level) as $player){
			if($player->eid !== false and $player->eid !== $e->eid and $e->class !== ENTITY_PLAYER and $e instanceof Entity){
				$e->spawn($player);
			}
		}
	}
	
	public function drop(Position $pos, Item $item){
		if($item->getID() === AIR or $item->count <= 0){
			return;
		}
		$i = 0;
		do { // drop the block to the first supporting block
		$i++;
		$v = new Vector3($pos->x, $pos->y - $i, $pos->z);
		$b = $pos->level->getBlock($v);
		if($b->isSolid === true) break;
		if(($b instanceof LiquidBlock) or $b->getID() === COBWEB or $b->getID() === LADDER or $b->getID() === FENCE or $b->getID() === STONE_WALL)
							break;
		
		}
		while ($i<200);
		if ($i==200) $i=0;
		$data = array(
			"x" => $pos->x + mt_rand(-10, 10) / 50,
			"y" => $pos->y + 0.19 - $i + 1,
			"z" => $pos->z + mt_rand(-10, 10) / 50,
			"level" => $pos->level,
			//"speedX" => mt_rand(-3, 3) / 8,
			"speedY" => mt_rand(5, 8) / 2,
			//"speedZ" => mt_rand(-3, 3) / 8,
			"item" => $item,
		);
		if($this->server->api->handle("item.drop", $data) !== false){
			for($count = $item->count; $count > 0; ){
				$item->count = min($item->getMaxStackSize(), $count);
				$count -= $item->count;
				$e = $this->add($pos->level, ENTITY_ITEM, $item->getID(), $data);
				$this->spawnToAll($e);
				$this->server->api->handle("entity.motion", $e);
			}
		}
	}

	public function spawnAll(Player $player){
		foreach($this->getAll($player->level) as $e){
			if($e->class !== ENTITY_PLAYER){
				$e->spawn($player);
			}
		}
	}

	public function remove($eid){
		if(isset($this->entities[$eid])){
			$entity = $this->entities[$eid];
			$this->entities[$eid] = null;
			unset($this->entities[$eid]);
			$entity->closed = true;
			$this->server->query("DELETE FROM entities WHERE EID = ".$eid.";");
			if($entity->class === ENTITY_PLAYER){
				$pk = new RemovePlayerPacket;
				$pk->eid = $entity->eid;
				$pk->clientID = 0;
				$this->server->api->player->broadcastPacket($this->server->api->player->getAll(), $pk);
			}else{
				$pk = new RemoveEntityPacket;
				$pk->eid = $entity->eid;
				$this->server->api->player->broadcastPacket($this->server->api->player->getAll($entity->level), $pk);
			}
			$this->server->api->dhandle("entity.remove", $entity);
			$entity = null;
			unset($entity);			
		}
	}
}
