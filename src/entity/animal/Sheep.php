<?php

class Sheep extends Animal{
	public $color;
	const TYPE = MOB_SHEEP;
	function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		$this->setSize($this->isBaby() ? 0.45 : 0.9, $this->isBaby() ? 0.675 : 1.3);
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"] : 8, "generic");
		$this->setName("Sheep");
		$this->data["Sheared"] = isset($this->data["Sheared"]) ? $this->data["Sheared"] : 0;
		$this->data["Color"] = isset($this->data["Color"]) ? $this->data["Color"] : $this->sheepColor();
		$this->setSpeed(0.25);
		$this->update();
		if($this->isSheared() and Entity::$updateOnTick){ //if ai enabled
			$this->server->schedule(mt_rand(60, 400), [$this, "eatGrass"], null, true); //unknown time
		}elseif($this->isBaby() and Entity::$updateOnTick){
			$this->server->schedule(mt_rand(400, 1000), [$this, "eatGrass"], null, true); //unknown time
		}
	}
	
	public function createSaveData(){
		$data = parent::createSaveData();
		$data["Color"] = @$this->data["Color"];
		$data["Sheared"] = @$this->data["Sheared"];
		return $data;
	}
	
	public function eatGrass(){
		$downBlock = $this->level->getBlock(new Vector3($this->x, $this->y-1, $this->z));
		if($downBlock->getID() !== GRASS){
			//console("eww i don't wanna eat this $downBlock");
			return false;
		}
		$pk = new EntityEventPacket;
		$pk->eid = $this->eid;
		$pk->event = EntityEventPacket::ENTITY_ANIM_10;
		$this->server->api->player->broadcastPacket($this->level->players, $pk);
		$this->server->schedule(38, [$this, "setSheared"], false);
		$this->level->setBlock(new Position($this->x, $this->y-1, $this->z, $this->level), new DirtBlock());
	}
	
	public function setSheared($v = null){
		$this->data["Sheared"] = $v === null ? !$this->isSheared() : $v;
		$this->updateMetadata();
	}
	
	public function isSheared(){
		return $this->data["Sheared"];
	}
	
	public function getColor(){
		return $this->data["Color"]; //color === 16 -> color = 0, color === 17 -> color = 1 ...
	}
	
	public function switchColorMeta($meta){
		return abs($meta - 15);
	}
	
	public function setColor($meta){
		$this->data["Color"] = $meta;
	}
	public function getDrops(){
		return ($this->isBaby() || $this->isSheared()) ? parent::getDrops() : [
			[WOOL, $this->getColor(), 1]
		];
	}
	
	public function isFood($id){
		return $id === WHEAT;
	}
	
	public function interactWith(Entity $e, $action){
		if($e->isPlayer() && $action === InteractPacket::ACTION_HOLD){
			$slot = $e->player->getHeldItem();
			if($slot->getID() === SHEARS){
				if(!$this->isSheared()){
					if($e->player->gamemode != 1) $slot->useOn($this);
					$this->setSheared(1);
					$this->server->api->entity->drop($this, BlockAPI::getItem(WOOL, $this->getColor(), mt_rand(1, 3)));
					//$this->server->schedule(20, [$this, "eatGrass"]);
					if($slot->getMetadata() >= $slot->getMaxDurability()){
						$e->player->removeItem($slot->getID(), $slot->getMetadata(), $slot->count, true);
					}else{
						$e->player->setSlot($e->player->slot, $slot);
					}
				}
				return true;
			}elseif($slot->getID() === DYE){
				$this->setColor($this->switchColorMeta($slot->getMetadata()));
				
				if(($e->player->gamemode & 0x01) === SURVIVAL){
					$e->player->removeItem($slot->getID(), $slot->getMetadata(), 1, true);
				}
			}
		}
		return parent::interactWith($e, $action);
	}
	
	public function getMetadata(){
		$d = parent::getMetadata();
		if(!isset($this->data["Sheared"])){
			$this->data["Sheared"] = 0;
		}
		$d[16]["value"] = ($this->data["Sheared"] << 4) | ($this->getColor() & 0x0F);
		return $d;
	}
	
	public function sheepColor(){ //a method from 0.8.1
		$c = mt_rand(0,100);
		if($c <= 4){
			return 0xF; //white
		}
		if($c <= 9){
			return 0x7;
		}
		if($c <= 14){
			return 0x8;
		}
		if($c <= 17){
			return 0xC;
		}
		if(mt_rand(0, 500)){
			return 0x0;
		}
		return 0x0;
	}
}