<?php
class Pig extends Animal implements Rideable{
	const TYPE = MOB_PIG;
	
	public function __construct(Level $level, $eid, $class, $type = 0, $data = []){
		parent::__construct($level, $eid, $class, $type, $data);
		$this->setHealth(isset($this->data["Health"]) ? $this->data["Health"]:10, "generic");
		$this->server = ServerAPI::request();
		$this->setSize($this->isBaby() ? 0.45 : 0.9, $this->isBaby() ? 0.45 : 0.9);
		$this->setName("Pig");
		$this->setSpeed(0.25);
		$this->update();
	}
	/**
	 * @return boolean
	 */
	public function isSaddled(){
		return (boolean) $this->getState();
	}
	
	/**
	 * @param boolean $value
	 */
	public function setSaddled($value = null){
		$this->setState($value === null ? !$this->getState() : $value);
	}
	
	public function canRide($e){
		return $this->isSaddled() && !($this->linkedEntity instanceof Entity);
	}

	public function interactWith(Entity $e, $action)
	{
		if($e->isPlayer() && $action === InteractPacket::ACTION_HOLD){
			$slot = $e->player->getHeldItem();
			if($this->canRide($e)){
				$this->linkedEntity = $e;
				$e->isRiding = true;
				$this->linkEntity($e, SetEntityLinkPacket::TYPE_RIDE);
				return true;
			}
			if($e->isRiding && $this->linkedEntity->eid = $e->eid){
				$this->linkEntity($e, SetEntityLinkPacket::TYPE_REMOVE);
				$e->isRiding = false;
				$this->linkedEntity = 0;
				return true;
			}
			if($slot->getID() === SADDLE){
				if(!$this->isSaddled()){
					$e->player->removeItem($slot->getID(), 0, 1);
					$this->setSaddled(1);
				}
				return true; //avoid further interactions
			}
			
		}
		return parent::interactWith($e, $action);
	}
	
	public function isFood($id){
		return $id === POTATO || $id === CARROT || $id === BEETROOT;
	}
	
	public function getDrops(){
		return $this->isBaby() ? parent::getDrops() : ($this->isSaddled() ? [
			[($this->fire > 0 ? COOKED_PORKCHOP : RAW_PORKCHOP), 0, mt_rand(0,2)],
			[SADDLE, 0, 1]
		] : [
			[($this->fire > 0 ? COOKED_PORKCHOP : RAW_PORKCHOP), 0, mt_rand(0,2)]
		]);
	}
}
