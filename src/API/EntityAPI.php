<?php

class EntityAPI{
    public $entities;
    private $server;
    private $eCnt = 1;
    
    function __construct(){
        $this->entities = [];
        $this->server = ServerAPI::request();
        
        $this->serverSpawnAnimals = $this->server->api->getProperty("spawn-animals");
        $this->serverSpawnMobs = $this->server->api->getProperty("spawn-mobs");
    }
    
    public function init(){
        $this->server->schedule(25, [$this, "updateEntities"], [], true);
        $this->server->api->console->register("summon", "<mob>", [$this, "commandHandler"]);
        $this->server->api->console->register("spawnmob", "<mob>", [$this, "commandHandler"]);
        $this->server->api->console->register("despawn", "", [$this, "CommandHandler"]);
    }
    
    
    public function commandHandler($cmd, $args, $issuer, $alias){
        $mob = [
            "chicken" => 10,
            "cow" => 11,
            "pig" => 12,
            "sheep" => 13,
            
            "zombie" => 32,
            "creeper" => 33,
            "skeleton" => 34,
            "spider" => 35,
            "pigman" => 36
        ];
        $output = "";
        switch($cmd){
            case "summon":
            case "spawnmob":
                if(!($issuer instanceof Player)){
                    $output .= "Please run this command in-game.";
                    break;
                }
                if((count($args) < 1) or (count($args) > 3)){
                    $output .= "Usage: /$cmd <mob> [amount] [baby]";
                    break;
                }
                
                if(is_int($args[0])) $type = $args[0];
                else $type = $mob[strtolower($args[0])];
                if($type != (10 or 11 or 12 or 13 or 32 or 33 or 34 or 35 or 36)){
                    $output .= "Unknown mob.";
                    break;
                }
                $mobName = ucfirst(array_flip($mob)[$type]);
                
                if(strtolower($args[1] === "baby") or strtolower($args[2] === "baby") and $type > 13){
                    $output .= "$mobName cannot be a baby!";
                    break;
                }
                
                $x = round($issuer->entity->x, 2, PHP_ROUND_HALF_UP);
                $y = round($issuer->entity->y, 2, PHP_ROUND_HALF_UP);
                $z = round($issuer->entity->z, 2, PHP_ROUND_HALF_UP);
                $level = $issuer->entity->level;
                $pos = new Position($x, $y, $z, $level);
                
                if(count($args) === 1){//summon <mob>
                    $this->summon($pos, ENTITY_MOB, $type);
                    $output .= "$mobName spawned in $x, $y, $z.";
                    break;
                }
                elseif(is_numeric($args[1])){//summon <mob> [amount]
                    $amount = (int) $args[1];
                    if($amount > 25){
                        $output .= "Cannot spawn > 25 mobs";
                        break;
                    }
                    
                    if(isset($args[2]) and strtolower($args[2]) === 'baby'){//summon <mob> [amount] [baby]
                        $isBaby = 1;
                    }
                    
                    for($cnt = $amount; $cnt > 0; --$cnt){
                        $this->summon($pos, ENTITY_MOB, $type, $isBaby === 1 ? ["IsBaby" => 1] : []);
                    }
                    
                    $output .= "$amount ".($isBaby === 1 ? "Baby" : "")." $mobName".(($type !== 13 || $amount > 1) ? "s" : "")." spawned in $x, $y, $z.";
                    break;
                }
                elseif(strtolower($args[1]) == "baby"){//summon <mob> [baby]
                    $this->summon($pos, ENTITY_MOB, $type, ["IsBaby" => 1]);
                    $output .= "Baby $mobName spawned in $x, $y, $z.";
                    break;
                }
                break;
            case "despawn":
                $cnt = 0;
				if(!isset($args[0])){
					$output .= "/despawn <all or (mobs,objects,items,fallings)>";
					break;
				}else{
					if($args[0] === "all"){
						$l = $this->server->query("SELECT EID FROM entities WHERE class = 2 and 3 and 4 and 5;");
					}else{
						$array = explode(",", strtolower($args[0]));
						if(count($array) > 4){
							$output .= "Many arguments!";
							break;
						}
						//terrible code
						$list = "";
						$temp = ["mobs" => "2", "objects" => "3", "items" => "4", "fallings" => "5"];
						foreach($array as $value){
							$list .= $temp[$value]." and ";
						}
						$despawning = substr($list, 0, -5);
						$l = $this->server->query("SELECT EID FROM entities WHERE class = ".$despawning.";");
					}
				}
                if($l !== false and $l !== true){
                    while(($e = $l->fetchArray(SQLITE3_ASSOC)) !== false){
                        $e = $this->get($e["EID"]);
                        if($e instanceof Entity){
                            $this->remove($e->eid);
                            $cnt++;
                        }
                    }
                }
                $output .= "$cnt entities have been despawned!";
                break;
        }
        return $output;
    }
    
    public function summon(Position $pos, $class, $type, Array $data = []){
        $entity = $this->add($pos->level, $class, $type, [
            "x" => $pos->x,
            "y" => $pos->y,
            "z" => $pos->z
        ] + $data);
        $this->spawnToAll($entity, $pos->level);
    }
    
    public function add(Level $level, $class, $type = 0, $data = []){
        $eid = $this->eCnt++;
        $efl = EntityRegistry::$entityList->getEntityFromTypeAndClass($type, $class);
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
    
    public function get($eid){
        if(isset($this->entities[$eid])){
            return $this->entities[$eid];
        }
        return false;
    }
    
    public function remove($eid){
        if(isset($this->entities[$eid])){
            $entity = $this->entities[$eid];
            $this->entities[$eid] = null;
            unset($this->entities[$eid]);
            $entity->closed = true;
            $this->server->query("DELETE FROM entities WHERE EID = " . $eid . ";");
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
    
    public function updateEntities(){
        $l = $this->server->query("SELECT EID FROM entities WHERE hasUpdate = 1;");
        
        if($l !== false and $l !== true){
            while(($e = $l->fetchArray(SQLITE3_ASSOC)) !== false){
                $e = $this->get($e["EID"]);
                if($e instanceof Entity){
                    $e->update();
                    $this->server->query("UPDATE entities SET hasUpdate = 0 WHERE EID = " . $e->eid . ";");
                }
            }
        }
    }
    
    public function updateRadius(Position $center, $radius = 15, $class = false){
        $this->server->query("UPDATE entities SET hasUpdate = 1 WHERE level = '" . $center->level->getName() . "' " . ($class !== false ? "AND class = $class " : "") . "AND abs(x - {$center->x}) <= $radius AND abs(y - {$center->y}) <= $radius AND abs(z - {$center->z}) <= $radius;");
    }
    
    public function getRadius(Position $center, $radius = 15, $class = false){
        $entities = [];
        $l = $this->server->query("SELECT EID FROM entities WHERE level = '" . $center->level->getName() . "' " . ($class !== false ? "AND class = $class " : "") . "AND abs(x - {$center->x}) <= $radius AND abs(y - {$center->y}) <= $radius AND abs(z - {$center->z}) <= $radius;");
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
    
    public function heal($eid, $heal, $cause){
        $this->harm($eid, -$heal, $cause);
    }
    
    public function harm($eid, $attack, $cause, $force = false){
        $e = $this->get($eid);
        if($e === false or $e->dead === true){
            return false;
        }
        $e->setHealth($e->getHealth() - $attack, $cause, $force);
    }
    
    public function drop(Position $pos, Item $item){
        if($item->getID() === AIR or $item->count <= 0){
            return;
        }
        $i = 0;
        do{ // drop the block to the first supporting block
            $i++;
            $v = new Vector3($pos->x, $pos->y - $i, $pos->z);
            $b = $pos->level->getBlock($v);
            if($b->isSolid === true)
                break;
                if(($b instanceof LiquidBlock) or $b->getID() === COBWEB or $b->getID() === LADDER or $b->getID() === FENCE or $b->getID() === STONE_WALL)
                    break;
                    
        }while($i < 200);
        $i %= 200; //if i >= 200, set to 0..1..2..199

        $data = [
        	"x" => $pos->x + mt_rand(-10, 10) / 50,
            "y" => $pos->y + 0.19 + 1 - $i,
            "z" => $pos->z + mt_rand(-10, 10) / 50,
            "level" => $pos->level,
            //"speedX" => mt_rand(-3, 3) / 8,
            //"speedY" => mt_rand(5, 8) / 2, speed is handled differently now
            //"speedZ" => mt_rand(-3, 3) / 8,
            "item" => $item,
		];
        if($this->server->api->handle("item.drop", $data) !== false){
        	for($count = $item->count; $count > 0;){
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
    
    public function getAll($level = null){
        if($level instanceof Level){
            $entities = [];
            $l = $this->server->query("SELECT EID FROM entities WHERE level = '" . $level->getName() . "';");
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
}