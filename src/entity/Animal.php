<?php
/*
TODO:
move methods
*/
abstract class Animal extends Creature implements Ageable, Breedable{
	
	public $parent;
	public $inLove; //do NOT add it into metadata, it doesnt send it to player
	public $age;
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setAge(isset($data["Age"]) ? $data["Age"] : 0);
		if(isset($this->data["IsBaby"]) && $this->data["IsBaby"] && $this->getAge() >= 0){
			$this->setAge(-24000);
		}
		
		$this->ai->addTask(new TaskTempt());
		$this->ai->addTask(new TaskPanic());
	}
	
	public function harm($dmg, $cause = "generic", $force = false){
		$ret = parent::harm($dmg, $cause, $force);
		$this->inPanic |= ($ret && is_numeric($cause));
		$this->inLove = false;
		return $ret;
	}
	
	public function isBaby(){
		return $this->getAge() < 0;
	}
	
	public function breed(){
		$c = $this->spawnChild();
		if($this->server->dhandle("entity.animal.breed", ["parent" => $this, "child" => $c]) !== false){
			$c->parent = &$this;
			$this->server->api->entity->spawnToAll($c);
		}
	}
	
	public function update(){
		parent::update();
		$age = $this->getAge() + 1; //100 - fast. debug, 1 - normal
		if($age >= 0 && $this->isBaby()){
			$this->setAge($age);
			$this->updateMetadata();
		}else{
			$this->setAge($age);
		}
	}
	
	public function getAge(){
		return $this->age;
	}
	
	public function setAge($i){
		$this->age = $i;
	}
	
	public function spawnChild()
	{
		return $this->server->api->entity->add($this->level, $this->class, $this->type, [
			"x" => $this->x + lcg_value() * mt_rand(-1, 1),
			"y" => $this->y,
			"z" => $this->z + lcg_value() * mt_rand(-1, 1),
			"IsBaby" => true,
			"Age" => -24000,
		]);
	}
	
	public function getMetadata(){
		$d = parent::getMetadata();
		$d[14]["value"] = $this->isBaby();
		return $d;
	}
	
	public function createSaveData(){
		$data = parent::createSaveData();
		$data["IsBaby"] = $this->isBaby();
		$data["Age"] = $this->getAge();
		return $data;
	}
	
	public function isInLove(){
		return $this->inLove > 0;
	}
	
	public function interactWith(Entity $e, $action){
		if($e->isPlayer() && $action === InteractPacket::ACTION_HOLD){
			$slot = $e->player->getHeldItem();
			if($this->isFood($slot->getID())){
				$e->player->removeItem($slot->getID(), $slot->getMetadata(), 1);
				$this->inLove = 600; //600 ticks, original mehod from mcpe
				return true;
			}
		}
		parent::interactWith($e, $action);
	}
	
	public function counterUpdate(){
		parent::counterUpdate();
		if($this->isInLove()){
			--$this->inLove;
		}
	}

	public function getDrops(){
		if($this->isBaby()){
			return [];
		}
		return parent::getDrops();
	}
}
